<?php

namespace App\Policies;

use App\Models\User;
use App\Models\peminjaman;

class PeminjamanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjamannya sendiri
        return $user->hasRole('siswa')
            && (int) $peminjaman->anggota?->user_id === (int) $user->id;
    }
}
