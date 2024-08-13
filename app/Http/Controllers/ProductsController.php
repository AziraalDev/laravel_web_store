<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $gallery = array_merge(
            [$product->thumbnailUrl],
            $product->images->pluck('url')->toArray() // Extract URLs as an array
        );

        return view('products.show', compact('product', 'gallery'));
    }
}
