<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        Log::info('Admin showing order', [
            'order_id' => $order->id,
            'items_count' => $order->items->count(),
            'items' => $order->items->toArray()
        ]);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
} 