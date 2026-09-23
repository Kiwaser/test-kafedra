<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function (Cart $item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'description' => $item->product->description,
                    'price' => $item->product->price,
                ];
            });

        return response()->json($items, 200);
    }

    public function store(Request $request, Product $product)
    {
        Cart::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return response()->json(['message' => 'Product add to card'], 201);
    }

    public function destroy(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden for you'], 403);
        }

        $cart->delete();

        return response()->json(['message' => 'Item removed from cart'], 200);
    }
}
