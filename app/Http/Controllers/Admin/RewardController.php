<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::orderBy('points_required', 'asc')->get();
        return view('admin.rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('admin.rewards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:150',
            'points_required' => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'stock'           => 'required|integer|min:0',
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('reward_images', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Reward::create($validated);
        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil ditambahkan.');
    }

    public function edit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:150',
            'points_required' => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'stock'           => 'required|integer|min:0',
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($reward->image_path && Storage::disk('public')->exists($reward->image_path)) {
                Storage::disk('public')->delete($reward->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('reward_images', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $reward->update($validated);
        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil diperbarui.');
    }

    public function destroy(Reward $reward)
    {
        if ($reward->image_path && Storage::disk('public')->exists($reward->image_path)) {
            Storage::disk('public')->delete($reward->image_path);
        }
        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('success', 'Hadiah berhasil dihapus.');
    }
}
