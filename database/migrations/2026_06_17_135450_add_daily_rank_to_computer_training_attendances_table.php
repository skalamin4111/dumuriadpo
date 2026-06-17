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
        Schema::table('computer_training_attendances', function (Blueprint $table) {
            $table->tinyInteger('daily_rank')->nullable()->after('status')->comment('1st, 2nd, 3rd best student of the day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computer_training_attendances', function (Blueprint $table) {
            $table->dropColumn('daily_rank');
        });
    }
};
