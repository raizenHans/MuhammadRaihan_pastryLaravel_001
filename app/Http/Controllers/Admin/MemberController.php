<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('user')->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'member_code' => 'required|string|unique:members',
            'nik' => 'required|string|unique:members',
            'phone' => 'nullable|string',
            'points' => 'required|numeric'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer'
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_code' => $validated['member_code'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'points' => $validated['points'],
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->user_id,
            'nik' => 'required|string|unique:members,nik,' . $member->id,
            'phone' => 'nullable|string',
            'points' => 'required|numeric'
        ]);

        $member->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $member->update([
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'points' => $validated['points'],
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Data Member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        // Karena on cascade, hapus User-nya maka Member juga terhapus
        $member->user->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member berhasil dihapus.');
    }
}
