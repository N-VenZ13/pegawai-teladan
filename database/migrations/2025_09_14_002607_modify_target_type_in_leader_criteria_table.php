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
        Schema::table('leader_criteria', function (Blueprint $table) {
            $table->enum('target_type', ['pegawai', 'ketua_tim', 'semua'])
                ->default('pegawai')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leader_criteria', function (Blueprint $table) {
            $table->enum('target_type', ['pegawai', 'ketua_tim'])
                ->default('pegawai')
                ->change();
        });
    }
};
