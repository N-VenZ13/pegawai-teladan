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
        Schema::create('discipline_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('discipline_criterion_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->default(0); // Nilai 0-100
            $table->timestamps();

            // Beri nama kustom yang pendek sebagai parameter kedua
            $table->unique(
                ['period_id', 'user_id', 'discipline_criterion_id'],
                'discipline_scores_unique' // <-- NAMA KUSTOM YANG PENDEK
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipline_scores');
    }
};
