<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('computer_training_attendances', function (Blueprint $table) {
            $table->boolean('is_advance_absence')->default(false)->after('daily_rank');
        });
    }

    public function down(): void
    {
        Schema::table('computer_training_attendances', function (Blueprint $table) {
            $table->dropColumn('is_advance_absence');
        });
    }
};
