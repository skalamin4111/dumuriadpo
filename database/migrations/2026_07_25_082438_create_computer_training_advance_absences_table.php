<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_training_advance_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->constrained('computer_training_students')->cascadeOnDelete();
            $table->date('absence_date')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'absence_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_training_advance_absences');
    }
};
