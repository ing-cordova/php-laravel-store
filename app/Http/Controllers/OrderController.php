<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
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

    public function placeOrder(Request $request)
    {
        $user = auth()->user();

        // Buscar el carrito del usuario
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        DB::beginTransaction();
        try {
            // Calcular total
            $total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            // Crear orden
            $order = Order::create([
                'user_id' => $user->id,
                'status_id' => 1, // Por ejemplo "Pending" en tu tabla order_status
                'total' => $total,
            ]);

            // Crear los items de la orden
            foreach ($cart->items as $cartItem) {
                // Verificar stock
                if ($cartItem->product->stock < $cartItem->quantity) {
                    throw new \Exception("Not enough stock for {$cartItem->product->name}");
                }

                // Descontar stock
                $cartItem->product->decrement('stock', $cartItem->quantity);

                // Crear item de la orden
                OrderProducts::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->total,
                ]);
            }

            // Vaciar carrito
            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully.',
                'order_id' => $order->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
