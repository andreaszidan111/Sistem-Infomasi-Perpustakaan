<?php

use App\Models\anggota;
use App\Models\buku;
use App\Models\kategori;
use App\Models\peminjaman;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $petugas = User::factory()->create();
    $petugas->givePermissionTo(Permission::findOrCreate('kelola peminjaman', 'web'));
    $this->actingAs($petugas, 'sanctum');

    $kategori = kategori::factory()->create();
    $buku = buku::factory()->create(['kategori_id' => $kategori->id]);
    $anggota = anggota::factory()->create();

    $this->peminjamanData = [
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => today()->subWeek(),
        'tanggal_kembali' => today()->addWeek(),
    ];
});

test('waiting and rejected loans can be deleted', function (string $status) {
    $peminjaman = peminjaman::create([
        ...$this->peminjamanData,
        'status' => $status,
    ]);

    $this->deleteJson("/api/peminjaman/{$peminjaman->id}")
        ->assertOk()
        ->assertJsonPath('message', 'Peminjaman berhasil dihapus.');

    $this->assertDatabaseMissing('peminjamans', ['id' => $peminjaman->id]);
})->with([
    'waiting' => [peminjaman::STATUS_MENUNGGU],
    'rejected' => [peminjaman::STATUS_DITOLAK],
]);

test('approved and returned loans cannot be deleted', function (string $status, ?string $tanggalDikembalikan) {
    $peminjaman = peminjaman::create([
        ...$this->peminjamanData,
        'status' => $status,
        'tanggal_dikembalikan' => $tanggalDikembalikan,
    ]);

    $this->deleteJson("/api/peminjaman/{$peminjaman->id}")
        ->assertUnprocessable()
        ->assertJsonPath(
            'message',
            'Hanya peminjaman yang belum diproses atau ditolak yang dapat dihapus.',
        );

    $this->assertDatabaseHas('peminjamans', ['id' => $peminjaman->id]);
})->with([
    'approved' => [peminjaman::STATUS_DISETUJUI, null],
    'returned' => [peminjaman::STATUS_DISETUJUI, today()->toDateString()],
]);
