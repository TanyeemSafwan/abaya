<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function index()
    { 
        $products = Product::with('brand', 'category', 'product_images')->orderBy('id','desc')->limit(8)->get();        
        return Inertia::render('User/Index', [
            'products' => $products,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);       
    }

    public function contact()
    {
        return Inertia::render('User/Contact');
    }

    public function about()
    {
        return Inertia::render('User/About');
    }

    public function orderHistory(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('created_by', $user->id)->get();
        return Inertia::render('User/OrderHistory', [
            'orders' => $orders
        ]);
    }
}
