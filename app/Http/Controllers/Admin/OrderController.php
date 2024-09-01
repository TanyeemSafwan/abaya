<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::get();
        $products = Product::with('category', 'brand', 'product_images')->get();
        return Inertia::render('Admin/Order/Index', [
            'orders' => OrderResource::collection(
                Order::latest()->paginate(10)
            ),
            'products' => $products,
            'orderItems' => $orderItems
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->user_address_id = $request->user_address_id === 'null' || $request->user_address_id === null 
        ? null 
        : $request->user_address_id;
        $order->phone = $request->phone;
        $order->name = $request->name;
        $order->address_1 = $request->address_1;
        // dd($request->user_address_id);
        $order->update();
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
        

    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->order_items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');

    }
}
