<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index() 
    {
        $products = Product::with('category', 'brand', 'product_images');
        $filterProducts = $products->filtered()->paginate(9)->withQueryString();
        
        $categories = Category::get();
        $brands = Brand::get();

        return Inertia::render('User/ProductList', [
            'products' => ProductResource::collection($filterProducts),
            'brands' => $brands,
            'categories' => $categories,
            'currentSort' => request('sort', 'newest')
        ]);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $productImages = ProductImage::where('product_id', $id)->get();

        $category = Category::where('id', $product['category_id'])->firstOrFail();
        $brand = Brand::where('id', $product['brand_id'])->firstOrFail();

        return Inertia::render('User/ProductDetail', [
            'product' => $product,
            'productImages' => $productImages,
            'category' => $category,
            'brand' => $brand
        ]);
    }
}
