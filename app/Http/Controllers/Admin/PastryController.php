<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PastryController extends Controller
{
    /**
     * Auto-set is_active berdasarkan stok:
     * - stok < 30 → nonaktif otomatis
     * - stok >= 30 → aktif otomatis
     * Override bisa dilakukan admin secara manual jika stok >= 30.
     */
    private function resolveIsActive(int $stock, bool $manualCheck): bool
    {
        if ($stock < 30) return false;
        return $manualCheck;
    }

    public function index()
    {
        $pastries = Pastry::orderBy('product_number', 'asc')->get();
        return view('admin.pastries.index', compact('pastries'));
    }

    public function create()
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Akses Ditolak. Operator tidak bisa menambah menu.');
        }
        return view('admin.pastries.create', ['type' => 'pastries', 'title' => 'Pastry']);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'product_code'   => 'required|string|unique:pastries,product_code',
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

        Pastry::create($validated);
        return redirect()->route('admin.pastries.index')->with('success', 'Pastry berhasil ditambahkan.');
    }

    public function edit(Pastry $pastry)
    {
        return view('admin.pastries.edit', ['pastry' => $pastry, 'type' => 'pastries', 'title' => 'Pastry']);
    }

    public function update(Request $request, Pastry $pastry)
    {
        $role = Auth::user()->role;

        if ($role === 'operator') {
            $request->validate([
                'price' => 'required|numeric',
                'stock' => 'required|numeric|min:0',
            ]);

            $stock     = (int) $request->stock;
            $isActive  = $this->resolveIsActive($stock, $request->has('is_active'));

            $pastry->update([
                'price'     => $request->price,
                'stock'     => $stock,
                'is_active' => $isActive,
            ]);

            return redirect()->route('admin.pastries.index')->with('success', 'Stok dan harga berhasil diupdate.');
        }

        // Admin — full update (product_code READONLY — tidak bisa diubah)
        $validated = $request->validate([
            'product_number' => 'required|numeric',
            'name'           => 'required|string|max:100',
            'price'          => 'required|numeric',
            'stock'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($pastry->image_path && Storage::disk('public')->exists($pastry->image_path)) {
                Storage::disk('public')->delete($pastry->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('image_produk', 'public');
        }

        $validated['is_active'] = $this->resolveIsActive((int)$validated['stock'], $request->has('is_active'));

        $pastry->update($validated);
        return redirect()->route('admin.pastries.index')->with('success', 'Pastry berhasil diperbarui.');
    }

    public function destroy(Pastry $pastry)
    {
        if (Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized.');
        }

        if ($pastry->image_path && Storage::disk('public')->exists($pastry->image_path)) {
            Storage::disk('public')->delete($pastry->image_path);
        }

        $pastry->delete();
        return redirect()->route('admin.pastries.index')->with('success', 'Pastry berhasil dihapus secara permanen.');
    }
}
