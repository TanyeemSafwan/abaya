<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index() 
    {
        $products = Product::with('category', 'brand', 'product_images');
        $filterProducts = $products->filtered()->paginate(16)->withQueryString();
        
        $categories = Category::get();
        $brands = Brand::get();

        return Inertia::render('User/ProductList', [
            'products' => ProductResource::collection($filterProducts),
            'brands' => $brands,
            'categories' => $categories,
            'currentSort' => request('sort', 'newest')
        ]);
    }
}
