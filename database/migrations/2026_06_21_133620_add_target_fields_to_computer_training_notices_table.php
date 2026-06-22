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
        Schema::table('computer_training_notices', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('body');
            $table->string('target_course')->nullable()->after('image_path');
            $table->unsignedBigInteger('target_batch_id')->nullable()->after('target_course');
            $table->unsignedBigInteger('target_student_id')->nullable()->after('target_batch_id');
            
            $table->foreign('target_batch_id')->references('id')->on('computer_training_batches')->nullOnDelete();
            $table->foreign('target_student_id')->references('id')->on('computer_training_students')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computer_training_notices', function (Blueprint $table) {
            $table->dropForeign(['target_batch_id']);
            $table->dropForeign(['target_student_id']);
            $table->dropColumn(['image_path', 'target_course', 'target_batch_id', 'target_student_id']);
        });
    }
};
