@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Your Orders</h1>
    <div class="grid grid-cols-1 gap-4">
        @foreach($orders as $order)
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
                <p class="text-gray-600">Status: {{ $order->status }}</p>
                <p class="text-lg font-bold">Total: ${{ $order->total }}</p>
                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:underline">View Details</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
