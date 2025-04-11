<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Events\ProductUpdated;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    public function fetchProducts()
    {
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();

        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['name' => $productData['title']],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price']
                ]
            );
        }

        // Broadcast the update
        event(new ProductUpdated());

        return redirect('/')->with('success', 'Products fetched successfully!');
    }
}
