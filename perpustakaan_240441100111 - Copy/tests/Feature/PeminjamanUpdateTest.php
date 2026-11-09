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
    $this->bukuAwal = buku::factory()->create(['kategori_id' => $kategori->id]);
    $this->bukuTujuan = buku::factory()->create(['kategori_id' => $kategori->id]);
    $this->anggotaAwal = anggota::factory()->create();
    $this->anggotaTujuan = anggota::factory()->create();
});

function dataPeminjamanUntukUpdate($anggotaId, $bukuId): array
{
    return [
        'anggota_id' => $anggotaId,
        'buku_id' => $bukuId,
        'tanggal_pinjam' => today()->toDateString(),
        'tanggal_kembali' => today()->addWeek()->toDateString(),
    ];
}

test('waiting loans can be updated', function () {
    $peminjaman = peminjaman::create([
        'anggota_id' => $this->anggotaAwal->id,
        'buku_id' => $this->bukuAwal->id,
        'tanggal_pinjam' => today()->subDay(),
        'tanggal_kembali' => today()->addDays(6),
        'status' => peminjaman::STATUS_MENUNGGU,
    ]);

    $this->putJson("/api/peminjaman/{$peminjaman->id}", dataPeminjamanUntukUpdate(
        $this->anggotaTujuan->id,
        $this->bukuTujuan->id,
    ))->assertOk()
        ->assertJsonPath('message', 'Peminjaman berhasil diperbarui.');

    $this->assertDatabaseHas('peminjamans', [
        'id' => $peminjaman->id,
        'anggota_id' => $this->anggotaTujuan->id,
        'buku_id' => $this->bukuTujuan->id,
        'status' => peminjaman::STATUS_MENUNGGU,
    ]);
});

test('loans that are no longer waiting cannot be updated', function (string $status) {
    $peminjaman = peminjaman::create([
        'anggota_id' => $this->anggotaAwal->id,
        'buku_id' => $this->bukuAwal->id,
        'tanggal_pinjam' => today()->subDay(),
        'tanggal_kembali' => today()->addDays(6),
        'status' => $status,
    ]);

    $this->putJson("/api/peminjaman/{$peminjaman->id}", dataPeminjamanUntukUpdate(
        $this->anggotaTujuan->id,
        $this->bukuTujuan->id,
    ))->assertUnprocessable()
        ->assertJsonPath('message', 'Hanya peminjaman berstatus menunggu yang dapat diubah.');

    $this->assertDatabaseHas('peminjamans', [
        'id' => $peminjaman->id,
        'anggota_id' => $this->anggotaAwal->id,
        'buku_id' => $this->bukuAwal->id,
        'status' => $status,
    ]);
})->with([
    'approved' => [peminjaman::STATUS_DISETUJUI],
    'rejected' => [peminjaman::STATUS_DITOLAK],
]);
