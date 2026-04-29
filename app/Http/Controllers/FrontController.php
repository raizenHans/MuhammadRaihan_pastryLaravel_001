<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pastry;
use App\Models\Drink;
use App\Models\Promo;
use App\Models\Cart;

class FrontController extends Controller
{
    public function catalog(Request $request)
    {
        $pastries = Pastry::where('is_active', true)->orderBy('product_number')->get();
        $drinks   = Drink::where('is_active', true)->orderBy('product_number')->get();
        $promos   = Promo::where('is_active', true)->orderBy('product_number')->get();

        // Force session persistence untuk menghindari session_id berubah-ubah jika kosong
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }

        // Hitung total item di keranjang
        $sessionId = $request->session()->getId();
        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');

        // Kirim existing cart items agar stepper bisa tampilkan qty yang sudah ada
        $cartItems = Cart::where('session_id', $sessionId)->get()
            ->keyBy(fn($item) => class_basename($item->productable_type) . '_' . $item->productable_id);

        return view('customer.catalog', compact('pastries', 'drinks', 'promos', 'cartCount', 'cartItems'));
    }

    public function cart(Request $request)
    {
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $sessionId = $request->session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)->get();
        $total     = $cartItems->sum('subtotal');

        return view('customer.cart', compact('cartItems', 'total'));
    }
}