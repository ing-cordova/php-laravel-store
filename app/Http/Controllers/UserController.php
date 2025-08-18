<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserOtps;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json(['error' => 'We are sorry but this user is already registered.'], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_temporal_password' => false,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verifica si el usuario existe
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Verifica si el usuario está bloqueado por intentos fallidos
        if (isset($user->login_attempts) && $user->login_attempts >= 5) {
            return response()->json(['error' => 'Account Blocked, please contact support.'], 429);
        }

        // Verifica la contraseña
        if (!password_verify($request->password, $user->password)) {
            // Suma intento fallido
            $user->login_attempts = ($user->login_attempts ?? 0) + 1;
            $user->save();
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Reinicia los intentos al login exitoso
        $user->login_attempts = 0;
        $user->save();

        if ($user->is_temporal_password) {
            return response()->json([
                'login' => 'success',
                'message' => 'This user must change the temporal password'
            ], 200);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_temporal_password' => $user->is_temporal_password,
        ]);
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User does not exist, please try with another one'], 404);
        }

        if($user->email_verified_at) {
            return response()->json(['error' => 'This user is already verified'], 409);
        }

        $otp = $this->generateOTP($request->email);

        $this->sendNotification(
            'Verificación de correo electrónico',
            'Su OTP es: ' . $otp,
            $request->email
        );

        return response()->json([
            'message' => 'Verification email sent',
        ], 200);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User does not exist, please try with another one'], 404);
        }

        $existingOtp = UserOtps::where('user_id', $user->id)->first();

        if (!$existingOtp || $existingOtp->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 401);
        }

        // If we reach here, the OTP is valid
        User::where('email', $request->email)->update(['email_verified_at' => now()]);
        UserOtps::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Email verified successfully'], 200);
    }

    public function sendRecoveryPasswordNotification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User does not exist, please try with another one'], 404);
        }

        if(!$user->is_temporal_password) {
            return response()->json(['error' => 'This user cannot recover the password, please contact support'], 409);
        }

        $newPassword = $this->generateTemporalPassword();

        $user->password = bcrypt($newPassword);
        $user->is_temporal_password = true;
        $user->save();

        $this->sendNotification(
            'Password Recovery',
            'Your new temporary password is: ' . $newPassword,
            $request->email
        );

        return response()->json([
            'message' => 'Recovery email sent',
        ], 200);
    }

    public function changeTemporalPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User does not exist, please try with another one'], 404);
        }

        if (!$user->is_temporal_password) {
            return response()->json(['error' => 'This user cannot change the password, please contact support'], 409);
        }

        $user->password = bcrypt($request->new_password);
        $user->is_temporal_password = false;
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    private function sendNotification(string $title, string $message, string $email){
        // Simula el envío de una notificación por consola (log)
        \Log::info("Notificación enviada", [
            'title' => $title,
            'message' => $message,
            'email' => $email,
        ]);

        // También puedes imprimir en consola directamente si ejecutas comandos artisan
        // echo "Notificación: $title - $message a $email\n";
    }

    public function generateOTP(string $email): string
    {
        $otp = (string) rand(100000, 999999);

        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('We are sorry but this user does not exist.');
        }

        $existingOtp = UserOtps::where('user_id', $user->id)->first();

        if ($existingOtp && $existingOtp->expires_at > now()) {
            // OTP is currently valid so we reuse it.
            return $existingOtp->otp;
        }

        // Create or update OTP
        UserOtps::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5)
            ]
        );

        return $otp;
    }

    public function generateTemporalPassword(): string 
    {
        $tempPassword = bin2hex(random_bytes(4)); // Generate a random 8-character hex string
        return $tempPassword;
    }
}
