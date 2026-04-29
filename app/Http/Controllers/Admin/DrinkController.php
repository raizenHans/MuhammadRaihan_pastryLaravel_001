<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DrinkController extends Controller
{
    private function resolveIsActive(int $stock, bool $manualCheck): bool
    {
        if ($stock < 30) return false;
        return $manualCheck;
    }

    public function index()
    {
        $pastries = Drink::orderBy('product_number', 'asc')->get();
        return view('admin.pastries.index', ['pastries' => $pastries, 'category' => 'Minuman', 'type' => 'drinks']);
    }

    public function create()
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Akses Ditolak. Operator tidak bisa menambah menu.');
        }
        return view('admin.pastries.create', ['type' => 'drinks', 'title' => 'Minuman']);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'product_code'   => 'required|string|unique:drinks,product_code',
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

        Drink::create($validated);
        return redirect()->route('admin.drinks.index')->with('success', 'Minuman berhasil ditambahkan.');
    }

    public function edit(Drink $drink)
    {
        return view('admin.pastries.edit', ['pastry' => $drink, 'type' => 'drinks', 'title' => 'Minuman']);
    }

    public function update(Request $request, Drink $drink)
    {
        $role = Auth::user()->role;

        if ($role === 'operator') {
            $request->validate([
                'price' => 'required|numeric',
                'stock' => 'required|numeric|min:0',
            ]);

            $stock    = (int) $request->stock;
            $isActive = $this->resolveIsActive($stock, $request->has('is_active'));

            $drink->update([
                'price'     => $request->price,
                'stock'     => $stock,
                'is_active' => $isActive,
            ]);

            return redirect()->route('admin.drinks.index')->with('success', 'Stok dan harga minuman berhasil diupdate.');
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
            if ($drink->image_path && Storage::disk('public')->exists($drink->image_path)) {
                Storage::disk('public')->delete($drink->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('image_produk', 'public');
        }

        $validated['is_active'] = $this->resolveIsActive((int)$validated['stock'], $request->has('is_active'));

        $drink->update($validated);
        return redirect()->route('admin.drinks.index')->with('success', 'Minuman berhasil diperbarui.');
    }

    public function destroy(Drink $drink)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        if ($drink->image_path && Storage::disk('public')->exists($drink->image_path)) {
            Storage::disk('public')->delete($drink->image_path);
        }

        $drink->delete();
        return redirect()->route('admin.drinks.index')->with('success', 'Minuman berhasil dihapus secara permanen.');
    }
}
