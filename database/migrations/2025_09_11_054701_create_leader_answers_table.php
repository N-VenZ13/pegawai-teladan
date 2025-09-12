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
        Schema::create('leader_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leader_id')->constrained('users')->cascadeOnDelete(); // Pimpinan yg menilai
            $table->foreignId('target_id')->constrained('users')->cascadeOnDelete(); // Pegawai yg dinilai
            $table->foreignId('leader_criterion_id')->constrained()->cascadeOnDelete(); // Kriteria yg dinilai
            $table->unsignedTinyInteger('score'); // Nilai 0-100
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leader_answers');
    }
};
