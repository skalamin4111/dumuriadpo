<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->longText('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent', 'critical'])->default('medium')->index();
            $table->enum('status', ['new', 'assigned', 'in_progress', 'on_hold', 'completed', 'pending_approval', 'cancelled', 'overdue'])->default('new')->index();
            $table->foreignId('assigned_employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('deadline_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->text('delay_reason')->nullable();
            $table->string('delay_status')->nullable();
            $table->timestamp('expected_completion_at')->nullable();
            $table->text('approval_comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'priority', 'deadline_at']);
        });

        Schema::create('task_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('comment');
            $table->json('attachments')->nullable();
            $table->timestamps();
        });

        Schema::create('task_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->boolean('is_completed')->default(false)->index();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_checklists');
        Schema::dropIfExists('task_comments');
        Schema::dropIfExists('tasks');
    }
};
