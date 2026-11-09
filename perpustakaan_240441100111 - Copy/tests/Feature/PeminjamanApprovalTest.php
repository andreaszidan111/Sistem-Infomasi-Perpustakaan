<?php

use App\Models\anggota;
use App\Models\buku;
use App\Models\kategori;
use App\Models\peminjaman;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $permission = Permission::findOrCreate('proses persetujuan peminjaman', 'web');
    $this->petugas = User::factory()->create();
    $this->petugas->givePermissionTo($permission);
    $this->actingAs($this->petugas, 'sanctum');

    $kategori = kategori::factory()->create();
    $this->buku = buku::factory()->create([
        'kategori_id' => $kategori->id,
        'stok' => 2,
    ]);
    $this->anggota = anggota::factory()->create();
});

test('approving a waiting loan decrements stock exactly once', function () {
    $peminjaman = peminjaman::create([
        'anggota_id' => $this->anggota->id,
        'buku_id' => $this->buku->id,
        'tanggal_pinjam' => today(),
        'tanggal_kembali' => today()->addWeek(),
        'status' => peminjaman::STATUS_MENUNGGU,
    ]);

    $this->postJson("/api/peminjaman/{$peminjaman->id}/setujui")
        ->assertOk()
        ->assertJsonPath('data.status', peminjaman::STATUS_DISETUJUI);

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => 1,
    ]);

    $this->postJson("/api/peminjaman/{$peminjaman->id}/setujui")
        ->assertUnprocessable();

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => 1,
    ]);
});

test('a loan cannot be approved when book stock is empty', function () {
    $this->buku->update(['stok' => 0]);

    $peminjaman = peminjaman::create([
        'anggota_id' => $this->anggota->id,
        'buku_id' => $this->buku->id,
        'tanggal_pinjam' => today(),
        'tanggal_kembali' => today()->addWeek(),
        'status' => peminjaman::STATUS_MENUNGGU,
    ]);

    $this->postJson("/api/peminjaman/{$peminjaman->id}/setujui")
        ->assertUnprocessable()
        ->assertJsonPath('message', 'Stok buku tidak tersedia.');

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => 0,
    ]);
    $this->assertDatabaseHas('peminjamans', [
        'id' => $peminjaman->id,
        'status' => peminjaman::STATUS_MENUNGGU,
    ]);
});

test('creating a student loan request does not decrement book stock', function () {
    $siswa = User::factory()->create();
    $siswa->givePermissionTo(Permission::findOrCreate('ajukan peminjaman', 'web'));
    anggota::factory()->create([
        'user_id' => $siswa->id,
    ]);

    $this->actingAs($siswa, 'sanctum')
        ->postJson('/api/siswa/peminjaman', [
            'buku_id' => $this->buku->id,
            'tanggal_kembali' => today()->addWeek()->toDateString(),
        ])
        ->assertCreated();

    $this->assertDatabaseHas('bukus', [
        'id' => $this->buku->id,
        'stok' => 2,
    ]);
});
