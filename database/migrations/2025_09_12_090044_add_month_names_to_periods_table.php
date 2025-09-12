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
        Schema::table('periods', function (Blueprint $table) {
            $table->string('month_1_name')->nullable()->after('end_date');
            $table->string('month_2_name')->nullable()->after('month_1_name');
            $table->string('month_3_name')->nullable()->after('month_2_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->dropColumn(['month_1_name', 'month_2_name', 'month_3_name']);
        });
    }
};
