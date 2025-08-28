<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
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

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock.'], 400);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $item = $cart->items->where('product_id', $request->product_id)->first();

        if($item)
        {
            $item->quantity += $request->quantity;
            $item->total = $item->quantity * $item->price;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total' => $product->price * $request->quantity
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully.'], 201);
    }
}