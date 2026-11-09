<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk mengambil data pengguna
        $query = User::with('roles')->latest();

        // 1. Filter pencarian nama atau email
        $search = $request->query('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filter berdasarkan role
        $role = $request->query('role');

        if (in_array($role, ['admin', 'petugas', 'siswa'], true)) {
            $query->role($role);
        } else {
            $role = '';
        }

        // 3. Filter berdasarkan status verifikasi email
        $status = $request->query('status');

        if ($status === 'verified') {
            $query->whereNotNull('email_verified_at');
        } elseif ($status === 'unverified') {
            $query->whereNull('email_verified_at');
        } else {
            $status = '';
        }
        $pengguna = $query->paginate(10)->withQueryString();

        $totalPengguna = User::count();
        $totalAdmin = User::role('admin')->count();
        $totalPetugas = User::role('petugas')->count();
        $totalSiswa = User::role('siswa')->count();
        $perluVerifikasi = User::whereNull('email_verified_at')->count();

        return view('admin.pengguna', compact(
            'pengguna',
            'totalPengguna',
            'totalAdmin',
            'totalPetugas',
            'totalSiswa',
            'perluVerifikasi',
            'search',
            'role',
            'status'
        ));
    }
}