<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    private function resolveIsActive(int $stock, bool $manualCheck): bool
    {
        if ($stock < 30) return false;
        return $manualCheck;
    }

    public function index()
    {
        $pastries = Promo::orderBy('product_number', 'asc')->get();
        return view('admin.pastries.index', ['pastries' => $pastries, 'category' => 'Promo', 'type' => 'promos']);
    }

    public function create()
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Akses Ditolak. Operator tidak bisa menambah menu.');
        }
        return view('admin.pastries.create', ['type' => 'promos', 'title' => 'Promo']);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'product_code'   => 'required|string|unique:promos,product_code',
            'product_number' => 'required|numeric',
            'name'           => 'required|string|max:100',
            'price'          => 'required|numeric',
            'stock'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('image_produk', 'public');
        }

        $validated['is_active'] = $this->resolveIsActive((int)$validated['stock'], $request->has('is_active'));

        Promo::create($validated);
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.pastries.edit', ['pastry' => $promo, 'type' => 'promos', 'title' => 'Promo']);
    }

    public function update(Request $request, Promo $promo)
    {
        $role = Auth::user()->role;

        if ($role === 'operator') {
            $request->validate([
                'price' => 'required|numeric',
                'stock' => 'required|numeric|min:0',
            ]);

            $stock    = (int) $request->stock;
            $isActive = $this->resolveIsActive($stock, $request->has('is_active'));

            $promo->update([
                'price'     => $request->price,
                'stock'     => $stock,
                'is_active' => $isActive,
            ]);

            return redirect()->route('admin.promos.index')->with('success', 'Stok dan harga promo berhasil diupdate.');
        }

        // Admin — product_code READONLY
        $validated = $request->validate([
            'product_number' => 'required|numeric',
            'name'           => 'required|string|max:100',
            'price'          => 'required|numeric',
            'stock'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($promo->image_path && Storage::disk('public')->exists($promo->image_path)) {
                Storage::disk('public')->delete($promo->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('image_produk', 'public');
        }

        $validated['is_active'] = $this->resolveIsActive((int)$validated['stock'], $request->has('is_active'));

        $promo->update($validated);
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        if ($promo->image_path && Storage::disk('public')->exists($promo->image_path)) {
            Storage::disk('public')->delete($promo->image_path);
        }

        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus secara permanen.');
    }
}
