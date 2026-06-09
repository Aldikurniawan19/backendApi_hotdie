<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get all orders for the authenticated user.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['items.product'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pesanan berhasil dimuat',
            'data'    => $orders,
        ]);
    }

    /**
     * Store a new order (Checkout).
     */
    public function store(Request $request)
    {
        $request->validate([
            'total'             => 'required|numeric',
            'shipping_address'  => 'required|string',
            'coupon_code'       => 'nullable|string',
            'discount'          => 'nullable|numeric',
            'notes'             => 'nullable|string',
            'payment_method'    => 'required|string',
            'items'             => 'required|array',
            'items.*.product_id'=> 'required|integer|exists:products,id',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.price'     => 'required|numeric',
            'items.*.variant'   => 'nullable|string',
        ]);

        $order = DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id'          => $request->user()->id,
                'total'            => $request->total,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
                'coupon_code'      => $request->coupon_code,
                'discount'         => $request->discount ?? 0,
                'notes'            => $request->notes,
                'payment_method'   => $request->payment_method,
            ]);

            foreach ($request->items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'variant'    => $item['variant'] ?? null,
                ]);
            }

            return $order;
        });

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'data'    => $order->load('items.product'),
        ], 201);
    }

    /**
     * Get details of a specific order.
     */
    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pesanan berhasil dimuat',
            'data'    => $order->load('items.product'),
        ]);
    }
}
