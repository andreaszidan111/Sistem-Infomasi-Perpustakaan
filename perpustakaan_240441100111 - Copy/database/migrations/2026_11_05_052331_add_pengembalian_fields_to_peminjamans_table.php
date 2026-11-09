<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->date('tanggal_dikembalikan')->nullable();
            $table->string('kondisi_buku')->nullable();
            $table->unsignedInteger('denda_keterlambatan')->default(0);
            $table->unsignedInteger('denda_kondisi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_dikembalikan',
                'kondisi_buku',
                'denda_keterlambatan',
                'denda_kondisi',
            ]);
        });
    }
};
