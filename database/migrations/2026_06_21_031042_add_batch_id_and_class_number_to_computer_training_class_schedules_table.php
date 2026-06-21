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
        Schema::table('computer_training_class_schedules', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->after('batch_name')->constrained('computer_training_batches')->nullOnDelete();
            $table->string('class_number')->nullable()->after('batch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computer_training_class_schedules', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn(['batch_id', 'class_number']);
        });
    }
};
