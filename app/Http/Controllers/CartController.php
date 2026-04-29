<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Pastry;
use App\Models\Drink;
use App\Models\Promo;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index(Request $request)
    {
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $sessionId = $request->session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)->get();
        $total = $cartItems->sum('subtotal');

        return view('customer.cart', compact('cartItems', 'total'));
    }

    // Menambah barang ke keranjang (legacy redirect - kept for backward compat)
    public function addToCart(Request $request)
    {
        return $this->ajaxAdd($request);
    }

    /**
     * AJAX: Tambah/perbarui item ke keranjang
     * Returns JSON {success, cartCount, message}
     */
    public function ajaxAdd(Request $request)
    {
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $sessionId = $request->session()->getId();

        $productId   = $request->product_id;
        $productType = 'App\\Models\\' . $request->product_type; // App\Models\Pastry, dll
        $quantity    = max(1, (int) $request->quantity);

        // Resolve product
        $product = $productType::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        $cart = Cart::where('session_id', $sessionId)
                    ->where('productable_id', $productId)
                    ->where('productable_type', $productType)
                    ->first();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->subtotal  = $cart->quantity * $cart->price;
            $cart->save();
        } else {
            $cart = Cart::create([
                'session_id'       => $sessionId,
                'productable_type' => $productType,
                'productable_id'   => $productId,
                'product_name'     => $product->name,
                'price'            => $product->price,
                'quantity'         => $quantity,
                'subtotal'         => $product->price * $quantity
            ]);
        }

        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'   => true,
                'cartCount' => $cartCount,
                'newQty'    => $cart->quantity,
                'message'   => $product->name . ' ditambahkan ke keranjang.',
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk ke keranjang!');
    }

    /**
     * AJAX: Set quantity item di keranjang
     * Mendukung dua mode:
     *   1. cart_id         → langsung lookup by PK (dari cart.blade.php)
     *   2. product_id+type → lookup by product (dari catalog stepper & modal)
     * qty=0 berarti hapus dari keranjang
     */
    public function ajaxUpdate(Request $request)
    {
        $sessionId = $request->session()->getId();
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $newQty = max(0, (int) $request->quantity);

        // ── Mode 1: cart_id langsung (cart page stepper) ──
        if ($request->filled('cart_id')) {
            $cart = Cart::where('id', $request->cart_id)
                        ->where('session_id', $sessionId)
                        ->first();
            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
            }
        }
        // ── Mode 2: product_id + product_type (catalog stepper / modal) ──
        else {
            $productType = 'App\\Models\\' . $request->product_type;
            $cart = Cart::where('session_id', $sessionId)
                        ->where('productable_id', $request->product_id)
                        ->where('productable_type', $productType)
                        ->first();

            // Jika belum ada di keranjang tapi qty > 0 → buat baru (seperti ajaxAdd)
            if (!$cart && $newQty > 0) {
                $product = $productType::find($request->product_id);
                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
                }
                $cart = Cart::create([
                    'session_id'       => $sessionId,
                    'productable_type' => $productType,
                    'productable_id'   => $request->product_id,
                    'product_name'     => $product->name,
                    'price'            => $product->price,
                    'quantity'         => $newQty,
                    'subtotal'         => $product->price * $newQty,
                ]);
                $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');
                return response()->json([
                    'success'     => true,
                    'cartCount'   => $cartCount,
                    'newQty'      => $cart->quantity,
                    'newSubtotal' => $cart->subtotal,
                ]);
            }

            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
            }
        }

        // ── Update atau hapus ──
        if ($newQty <= 0) {
            $cart->delete();
            $cart = null;
        } else {
            $cart->quantity = $newQty;
            $cart->subtotal = $cart->price * $newQty;
            $cart->save();
        }

        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');

        return response()->json([
            'success'     => true,
            'cartCount'   => $cartCount,
            'newQty'      => $cart ? $cart->quantity : 0,
            'newSubtotal' => $cart ? $cart->subtotal  : 0,
        ]);
    }

    /**
     * AJAX: Get cart item count (for badge updates)
     */
    public function cartCount(Request $request)
    {
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $sessionId = $request->session()->getId();
        $count = Cart::where('session_id', $sessionId)->sum('quantity');
        return response()->json(['count' => $count]);
    }

    // Menghapus barang dari keranjang
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * AJAX: Hapus item langsung (tanpa redirect)
     */
    public function ajaxRemove(Request $request)
    {
        if (!$request->session()->has('cart_active')) {
            $request->session()->put('cart_active', true);
        }
        $sessionId = $request->session()->getId();
        $cartId    = $request->cart_id;

        $cart = Cart::where('id', $cartId)
                    ->where('session_id', $sessionId)
                    ->first();

        if ($cart) {
            $cart->delete();
        }

        $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');
        $newTotal  = Cart::where('session_id', $sessionId)->sum('subtotal');

        return response()->json([
            'success'   => true,
            'cartCount' => $cartCount,
            'newTotal'  => $newTotal,
        ]);
    }
}