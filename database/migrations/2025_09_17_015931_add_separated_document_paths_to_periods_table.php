<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periods', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['sk_file_path', 'sertifikat_file_path']);

            // Tambahkan 4 kolom baru
            $table->string('sk_pegawai_path')->nullable();
            $table->string('sertifikat_pegawai_path')->nullable();
            $table->string('sk_ketua_tim_path')->nullable();
            $table->string('sertifikat_ketua_tim_path')->nullable();
        });
    }

    public function down(): void // Untuk rollback
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->dropColumn([
                'sk_pegawai_path',
                'sertifikat_pegawai_path',
                'sk_ketua_tim_path',
                'sertifikat_ketua_tim_path'
            ]);
            // Buat kembali kolom lama
            $table->string('sk_file_path')->nullable();
            $table->string('sertifikat_file_path')->nullable();
        });
    }
};
