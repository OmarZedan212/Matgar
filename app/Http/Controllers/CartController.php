<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)
            ->whereNull('order_id')
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $total    = $subtotal;

        return view('customer.cart', compact('cartItems', 'subtotal', 'total'));
    }

    // Add item to cart
    public function store(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->id;
        $price = $request->price;
        $quantity = $request->quantity ?? 1;

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)->whereNull('order_id')
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Update Quantity
    public function update(Request $request)
    {
        $quantities = $request->quantity ?? [];
        $userId = Auth::id();

        foreach ($quantities as $id => $qty) {
            $cartItem = Cart::where('user_id', $userId)->where('id', $id)->first();
            if ($cartItem && $qty > 0) {
                $cartItem->quantity = $qty;
                $cartItem->save();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    // Remove single item

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        if ($cartItem) {
            $cartItem->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }
    public function delivery()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->whereNull('order_id')->get();

        return view('customer.delivery', compact('cartItems', 'user'));
    }
    

public function confirmDelivery(Request $request)
{
    $user = Auth::user();

    $cartItems = Cart::with('product')
        ->where('user_id', $user->id)
        ->whereNull('order_id')
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Your cart is empty.');
    }

    foreach ($cartItems as $item) {
        if (!$item->product) {
            return redirect()->route('cart.index')
                ->with('error', 'One of the products is no longer available.');
        }

        if ($item->product->qty < $item->quantity) {
            return redirect()->route('cart.index')
                ->with('error', "Not enough stock for {$item->product->name}. Available: {$item->product->qty}, requested: {$item->quantity}.");
        }
    }

    DB::transaction(function () use ($request, $user, $cartItems) {

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $order = Order::create([
            'user_id' => $user->id,
            'name'    => $request->name ?? $user->name ?? 'Unknown',
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'total'   => $total,
        ]);

        Cart::where('user_id', $user->id)
            ->whereNull('order_id')
            ->update(['order_id' => $order->id]);

        foreach ($cartItems as $item) {
            $productId = $item->product->id;
            $qty       = $item->quantity;

            Product::where('id', $productId)
                ->decrement('qty', $qty);
        }
    });

    return redirect()->route('home')
        ->with('status', 'Order placed successfully!');
}

}
