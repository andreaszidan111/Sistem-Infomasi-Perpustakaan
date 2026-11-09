<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();
        });

        // Hubungkan anggota dengan akun berdasarkan email yang sama.
        $anggotas = DB::table('anggotas')->whereNull('user_id')->get();

        foreach ($anggotas as $anggota) {
            $user = DB::table('users')
                ->where('email', $anggota->email)
                ->first();

            if ($user) {
                DB::table('anggotas')
                    ->where('id', $anggota->id)
                    ->update(['user_id' => $user->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropUnique('anggotas_user_id_unique');
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
