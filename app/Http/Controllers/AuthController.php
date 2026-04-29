<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Proses Pendaftaran Member
    public function registerProcess(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nik' => 'required|string|size:16|unique:members',
            'phone' => 'nullable|string|max:15'
        ]);

        // 1. Buat Data User (Untuk Login)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'is_active' => true
        ]);

        // 2. Generate Kode Member Cerdas (Format: CS + Tahun + 8 digit NIK awal)
        $tahun = date('y');
        $nikFront = substr($request->nik, 0, 8);
        $count = Member::whereYear('created_at', date('Y'))->count() + 1;
        $kodeMember = "CS" . str_pad($count, 3, '0', STR_PAD_LEFT) . $tahun . $nikFront;

        // 3. Buat Data Member (Untuk Kasir & Poin)
        Member::create([
            'user_id' => $user->id,
            'member_code' => $kodeMember,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'points' => 0 // Awal poin 0
        ]);

        // Langsung Login-kan user setelah berhasil daftar
        Auth::login($user);

        return back()->with('success', 'Pendaftaran berhasil! Kode Member Anda: ' . $kodeMember);
    }

    // Proses Login Biasa
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Arahkan berdasarkan role (Admin/Operator/Customer)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang, Admin.');
            } elseif (Auth::user()->role === 'operator') {
                return redirect()->intended('/operator/orders')->with('success', 'Selamat bekerja, Operator.');
            }

            return back()->with('success', 'Berhasil masuk ke akun Anda!');
        }

        return back()->with('error', 'Email atau Password salah.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}