<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_training_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('student_id')->nullable()->index();
            $table->string('name')->index();
            $table->string('phone')->nullable()->index();
            $table->string('guardian_phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('course')->index();
            $table->date('admission_date')->nullable()->index();
            $table->enum('status', ['lead', 'admitted', 'active', 'completed', 'dropped'])->default('admitted')->index();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('company_id');
        });

        Schema::create('computer_training_class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('course')->index();
            $table->string('batch_name')->index();
            $table->string('instructor')->nullable();
            $table->string('room')->nullable();
            $table->date('class_date')->index();
            $table->time('starts_at');
            $table->time('ends_at');
            $table->text('topic')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'class_date']);
        });

        Schema::create('computer_training_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->constrained('computer_training_students')->cascadeOnDelete();
            $table->foreignId('class_schedule_id')->nullable()->constrained('computer_training_class_schedules')->nullOnDelete();
            $table->date('attendance_date')->index();
            $table->enum('status', ['present', 'absent', 'late'])->default('present')->index();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'attendance_date']);
        });

        Schema::create('computer_training_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('class_schedule_id')->nullable()->constrained('computer_training_class_schedules')->nullOnDelete();
            $table->string('title');
            $table->string('course')->index();
            $table->date('exam_date')->index();
            $table->time('starts_at')->nullable();
            $table->unsignedInteger('total_marks')->default(100);
            $table->text('syllabus')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'exam_date']);
        });

        Schema::create('computer_training_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->constrained('computer_training_students')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->date('due_date')->index();
            $table->date('paid_at')->nullable()->index();
            $table->enum('status', ['due', 'partial', 'paid', 'waived'])->default('due')->index();
            $table->string('payment_method')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'status', 'due_date']);
        });

        Schema::create('computer_training_marketing_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->index();
            $table->string('phone')->nullable()->index();
            $table->string('interested_course')->nullable()->index();
            $table->string('source')->nullable()->index();
            $table->enum('status', ['new', 'contacted', 'interested', 'admitted', 'lost'])->default('new')->index();
            $table->timestamp('next_follow_up_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'status']);
        });

        Schema::create('computer_training_notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('body');
            $table->date('publish_date')->index();
            $table->enum('audience', ['all', 'students', 'leads', 'staff'])->default('all')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->index(['company_id', 'publish_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_training_notices');
        Schema::dropIfExists('computer_training_marketing_leads');
        Schema::dropIfExists('computer_training_fees');
        Schema::dropIfExists('computer_training_exams');
        Schema::dropIfExists('computer_training_attendances');
        Schema::dropIfExists('computer_training_class_schedules');
        Schema::dropIfExists('computer_training_students');
    }
};
