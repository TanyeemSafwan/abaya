<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);
        $perPage = 10;

        $products = Product::with('category', 'brand', 'product_images')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate($perPage);

        return Inertia::render('Search', [
            'query' => $query,
            'products' => $products,
    ]);
}
}