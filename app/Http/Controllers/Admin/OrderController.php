<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Order/Index', [
            'orders' => OrderResource::collection(
                Order::latest()->paginate(10)
            )
        ]);
    }
    public function delete($id)
    {
        $order = Order::findOrFail($id)->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');

    }
}
