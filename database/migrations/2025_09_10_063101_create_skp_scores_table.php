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
        Schema::create('skp_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Kolom baru untuk nilai bulanan
            $table->decimal('month_1_score', 5, 2)->default(0); // Nilai bulan pertama
            $table->decimal('month_2_score', 5, 2)->default(0); // Nilai bulan kedua
            $table->decimal('month_3_score', 5, 2)->default(0); // Nilai bulan ketiga

            $table->timestamps();

            // Menambahkan unique constraint agar 1 user hanya punya 1 baris data skp per periode
            $table->unique(['period_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp_scores');
    }
};
