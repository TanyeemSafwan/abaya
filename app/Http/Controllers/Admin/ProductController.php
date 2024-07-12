<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::get();
        $brands = Brand::get();
        $categories= Category::get();

        return Inertia::render('Admin/Product/Index',
         [
            'products' => $products,
             'brands' => $brands,
              'categories' => $categories
            ]);
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        //check if product have images to upload

        if($request->hasFile('product_images')) 
        {
            foreach ($productImages as $image) {
                //generate a unique name
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                //store the image in the public foler
                $image->move('product_images', $uniqueName);
                //create a new product image record with the product_id and unque name
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }
}
