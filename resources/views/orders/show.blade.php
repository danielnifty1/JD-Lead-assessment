@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="border-t border-b py-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Order Date</h3>
                        <p class="mt-1">{{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total Amount</h3>
                        <p class="mt-1 font-semibold">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
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
                            <p class="font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('orders.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Back to Orders
                </a>
                @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Cancel Order
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 