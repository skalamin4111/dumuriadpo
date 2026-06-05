<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('priority')->default('medium');
            $table->unsignedInteger('default_sla_minutes')->default(0);
            $table->json('checklist')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'is_active']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('parent_task_id')->nullable()->after('id')->constrained('tasks')->nullOnDelete();
            $table->foreignId('task_template_id')->nullable()->after('parent_task_id')->constrained('task_templates')->nullOnDelete();
            $table->unsignedInteger('estimated_minutes')->default(0)->after('progress');
            $table->unsignedInteger('actual_minutes')->default(0)->after('estimated_minutes');
            $table->timestamp('sla_due_at')->nullable()->after('deadline_at')->index();
            $table->timestamp('reviewed_at')->nullable()->after('completed_at');
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')->constrained('users')->nullOnDelete();
            $table->boolean('is_recurring')->default(false)->after('approval_comments')->index();
            $table->string('recurrence_rule')->nullable()->after('is_recurring');
            $table->index(['company_id', 'department_id', 'status']);
            $table->index(['assigned_employee_id', 'status', 'deadline_at']);
        });

        Schema::create('task_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('depends_on_task_id')->constrained('tasks')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['task_id', 'depends_on_task_id']);
        });

        Schema::create('task_work_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('minutes');
            $table->text('notes')->nullable();
            $table->timestamp('worked_at')->index();
            $table->timestamps();
        });

        Schema::create('escalation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('minutes_after_due');
            $table->string('notify_role');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_task_id');
            $table->dropConstrainedForeignId('task_template_id');
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['estimated_minutes', 'actual_minutes', 'sla_due_at', 'reviewed_at', 'is_recurring', 'recurrence_rule']);
        });

        Schema::dropIfExists('escalation_rules');
        Schema::dropIfExists('task_work_logs');
        Schema::dropIfExists('task_dependencies');
        Schema::dropIfExists('task_templates');
    }
};
