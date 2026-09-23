<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('products')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function (Order $order) {
                return [
                    'id' => $order->id,
                    'products' => $order->products->pluck('id'),
                    'order_price' => $order->order_price,
                ];
            });

        return response()->json($orders, 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Cart is empty',
                ],
            ], 422);
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_price' => $cartItems->sum(fn ($item) => $item->product->price),
            ]);

            $order->products()->attach($cartItems->pluck('product_id'));

            Cart::where('user_id', $user->id)->delete();

            return $order;
        });

        return response()->json([
            'order_id' => $order->id,
            'message' => 'Order is processed',
        ], 201);
    }
}
