<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastry;
use App\Models\Drink;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ProductController — mengelola operasi lintas kategori:
 * - changeCategory: pindah produk dari satu tabel ke tabel lain
 * - reorder: ubah product_number via AJAX drag-and-drop
 */
class ProductController extends Controller
{
    /**
     * Pindah produk ke kategori lain (misal Pastry → Drink)
     */
    public function changeCategory(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|integer',
            'source_type'      => 'required|in:Pastry,Drink,Promo',
            'target_type'      => 'required|in:Pastry,Drink,Promo',
        ]);

        if ($request->source_type === $request->target_type) {
            return response()->json(['success' => false, 'message' => 'Kategori sumber dan tujuan sama.'], 422);
        }

        $sourceModel = 'App\\Models\\' . $request->source_type;
        $targetModel = 'App\\Models\\' . $request->target_type;

        $source = $sourceModel::findOrFail($request->product_id);

        // Hitung product_number berikutnya di kategori tujuan
        $nextNumber = $targetModel::max('product_number') + 1;

        // Buat produk baru di kategori tujuan dengan data yang sama
        $targetModel::create([
            'product_code'   => $source->product_code,
            'product_number' => $nextNumber,
            'name'           => $source->name,
            'price'          => $source->price,
            'stock'          => $source->stock,
            'description'    => $source->description,
            'image_path'     => $source->image_path,
            'is_active'      => $source->is_active,
        ]);

        // Hapus dari kategori asal (tanpa hapus gambar — gambar shared)
        $source->delete();

        return response()->json([
            'success' => true,
            'message' => "Produk berhasil dipindah dari {$request->source_type} ke {$request->target_type}.",
        ]);
    }

    /**
     * Perbarui urutan produk (product_number) via AJAX
     * Expects: [{id, type, order}, ...] sorted array
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'items'         => 'required|array',
            'items.*.id'    => 'required|integer',
            'items.*.type'  => 'required|in:Pastry,Drink,Promo',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            $model = 'App\\Models\\' . $item['type'];
            $model::where('id', $item['id'])->update(['product_number' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil disimpan.']);
    }
}
