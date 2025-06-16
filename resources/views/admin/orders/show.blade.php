@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-900">
                ← Back to Orders
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Customer Information</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Order Information</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-900">Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
                        <p class="text-sm text-gray-900">Total: ${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-4">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Update Order Status</h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <h3 class="font-medium">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="font-medium">${{ number_format($item->quantity * $item->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 