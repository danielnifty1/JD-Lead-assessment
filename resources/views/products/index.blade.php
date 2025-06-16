@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-lg font-bold">${{ $product->price }}</p>
                <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">View Details</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
