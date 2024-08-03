<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function store (Request $request)
    {
        $user = $request->user();
        $carts = $request->carts;
        $products = $request->products;

        $mergedData = [];

        // Loop through the "carts" array and merge with "products" data
        foreach ($carts as $cartItem) {
            foreach ($products as $product) {
                if ($cartItem["product_id"] == $product["id"]) {
                    // Merge the cart item with product data
                    $mergedData[] = array_merge($cartItem, ["title" => $product["title"], 'price' => $product['price']]);
                }
            }
        }

        if($user) {
            $newAddress = $request->address;
        if ($newAddress['address1'] != null) {
            $address = UserAddress::where('isMain', 1)->count();
            if ($address > 0) {
                $address = UserAddress::where('isMain', 1)->update(['isMain' => 0]);
            }
            $address = new UserAddress();
            $address->address1 = $newAddress['address1'];
            $address->city = $newAddress['city'];
            $address->user_id = Auth::user()->id;
            $address->save();
        }
        $mainAddress = $user->user_address()->where('isMain', 1)->first();
        if ($mainAddress) {
            $cartItems = CartItem::where(['user_id' => $user->id])->get();

            if (count($cartItems) > 0) {
                $order = new Order();
                $order->status = 'Pending';
                $order->phone = $request->address['phone'];
                $order->name = $request->address['name'];
                $order->address_1 = $request->address['address1'];
                $order->address_1 = $request->address['city'];
                $order->total_price = $request->total;
                $order->created_by = $user->id;
                // If a main address with isMain = 1 exists, set its id as customer_address_id
                $order->user_address_id = $mainAddress->id;
                $order->save();
                foreach ($cartItems as $cartItem) {
                    $specificProduct = Product::where('id', $cartItem['product_id'])->first();
                    OrderItem::create([
                        'order_id' => $order->id, // Assuming you have an 'id' field in your orders table
                        'product_id' => $cartItem->product_id,
                        'name' => $specificProduct->title,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $cartItem->product->price, // You may adjust this depending on your logic
                    ]);
                $cartItem->delete();
                //remove cart items from cookies
                $cartItems = Cart::getCookieCartItems();
                foreach ($cartItems as $item) {
                    unset($item);
                }
                array_splice($cartItems, 0, count($cartItems));
                Cart::setCookieCartItems($cartItems);
                }   
            }
         }
        } else {
            function findIndex($products, $id) {
                for ($i = 0; $i < count($products); $i++) {
                    if ($products[$i]['id'] === $id) {
                        return $i;
                    }
                }
                return -1;
            }
            if (count($carts) > 0) {
                $order = new Order();
                $order->total_price = $request->total;
                // If a main address with isMain = 1 exists, set its id as customer_address_id
                $order->phone = $request->address['phone'];
                $order->address_1 = $request->address['address1'];
                $order->name = $request->address['name'];
                $order->city = $request->address['city'];
                $order->save();
                // $cartItems = CartItem::where([])
                // foreach ($cartItems as )
                foreach ($carts as $cart) {
                    $specificProduct = Product::where('id', $cart['product_id'])->first();
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart['product_id'],
                        'name' => $specificProduct->title,
                        'quantity' => $cart['quantity'],
                        'unit_price' => $cart['price']
                    ]);
                }
                Cart::setCookieCartItems([]);
            }
        }
    }
}
