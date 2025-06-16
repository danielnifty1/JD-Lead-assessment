@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            @foreach($cartItems as $item)
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-medium">{{ $item->product->name }}</h3>
                        <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-medium">${{ number_format($item->quantity * $item->product->price, 2) }}</p>
                </div>
            @endforeach
            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold">Total:</span>
                    <span class="text-lg font-bold">${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Complete Your Order</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 mb-2">Shipping Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Place Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 