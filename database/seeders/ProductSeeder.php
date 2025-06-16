<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation and premium sound quality.',
                'price' => 199.99,
                'stock' => 50,
            ],
            [
                'name' => 'Smart Watch Series 5',
                'description' => 'Latest smartwatch with health monitoring, GPS, and long battery life.',
                'price' => 299.99,
                'stock' => 30,
            ],
            [
                'name' => 'Professional DSLR Camera',
                'description' => '24MP DSLR camera with 4K video recording and interchangeable lenses.',
                'price' => 899.99,
                'stock' => 15,
            ],
            [
                'name' => 'Ultra HD Smart TV 55"',
                'description' => '55-inch 4K Smart TV with HDR and built-in streaming apps.',
                'price' => 699.99,
                'stock' => 20,
            ],
            [
                'name' => 'Gaming Laptop Pro',
                'description' => 'High-performance gaming laptop with RTX graphics and 16GB RAM.',
                'price' => 1299.99,
                'stock' => 10,
            ],
            [
                'name' => 'Wireless Earbuds',
                'description' => 'True wireless earbuds with active noise cancellation and water resistance.',
                'price' => 149.99,
                'stock' => 100,
            ],
            [
                'name' => 'Smart Home Hub',
                'description' => 'Central control for all your smart home devices with voice assistant.',
                'price' => 79.99,
                'stock' => 45,
            ],
            [
                'name' => 'Portable Power Bank',
                'description' => '20000mAh power bank with fast charging and multiple USB ports.',
                'price' => 49.99,
                'stock' => 75,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 