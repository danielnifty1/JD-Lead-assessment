<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = auth()->user()->cartItems;
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $cartItems = auth()->user()->cartItems;
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create the order
        $order = new Order();
        $order->user_id = auth()->id();
        $order->status = 'pending';
        $order->total = $total;
        $order->save();

        Log::info('Created order', ['order_id' => $order->id]);

        // Create order items from cart items
        foreach ($cartItems as $cartItem) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);
            
            Log::info('Created order item', [
                'order_item_id' => $orderItem->id,
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);
        }

        // Clear the cart
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // Logic to create a new order
        $order = new Order();
        $order->user_id = auth()->id();
        $order->status = 'pending';
        $order->total = $request->total;
        $order->save();
        return redirect()->route('orders.index');
    }

    public function show(Order $order)
    {
        $order->load(['items.product']); // Eager load the items and their products
        Log::info('Showing order', [
            'order_id' => $order->id,
            'items_count' => $order->items->count(),
            'items' => $order->items->toArray()
        ]);
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        // Update order status to cancelled
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.show', $order)->with('success', 'Order has been cancelled.');
    }
}
