@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                        <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                        <div class="text-2xl font-bold text-blue-600 mb-4">${{ number_format($product->price, 2) }}</div>
                        <div class="mb-4">
                            <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                        </div>

                        @auth
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Login to Purchase
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
