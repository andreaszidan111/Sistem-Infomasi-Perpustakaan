<?php

use App\Models\anggota;
use App\Models\buku;
use App\Models\kategori;
use App\Models\peminjaman;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $permission = Permission::findOrCreate('catat pengembalian', 'web');
    $petugas = User::factory()->create();
    $petugas->givePermissionTo($permission);
    $this->actingAs($petugas, 'sanctum');

    $kategori = kategori::factory()->create();
    $this->buku = buku::factory()->create([
        'kategori_id' => $kategori->id,
        'stok' => 1,
    ]);
    $anggota = anggota::factory()->create();
    $this->peminjaman = peminjaman::create([
        'anggota_id' => $anggota->id,
        'buku_id' => $this->buku->id,
        'tanggal_pinjam' => today()->subWeek(),
        'tanggal_kembali' => today()->addWeek(),
        'status' => peminjaman::STATUS_DISETUJUI,
    ]);
});

test('returning a book updates stock according to its condition', function (string $kondisi, int $stokAkhir) {
    $this->postJson("/api/peminjaman/{$this->peminjaman->id}/pengembalian", [
        'kondisi_buku' => $kondisi,
    ])->assertOk()
        ->assertJsonPath('data.kondisi_buku', $kondisi);

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => $stokAkhir,
    ]);
    $this->assertDatabaseHas('peminjamans', [
        'id' => $this->peminjaman->id,
        'kondisi_buku' => $kondisi,
        'tanggal_dikembalikan' => today()->toDateString(),
    ]);
})->with([
    'baik dikembalikan ke stok' => ['Baik', 2],
    'rusak ringan masih dapat dipinjam' => ['Rusak Ringan', 2],
    'rusak berat tidak ditambahkan ke stok' => ['Rusak Berat', 1],
    'buku hilang tidak ditambahkan ke stok' => ['Hilang', 1],
]);

test('processing the same return twice does not add stock twice', function () {
    $url = "/api/peminjaman/{$this->peminjaman->id}/pengembalian";

    $this->postJson($url, ['kondisi_buku' => 'Baik'])->assertOk();
    $this->postJson($url, ['kondisi_buku' => 'Baik'])->assertUnprocessable();

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => 2,
    ]);
});
