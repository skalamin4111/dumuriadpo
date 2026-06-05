<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('task_id')->constrained()->nullOnDelete();
            $table->string('service_section')->nullable()->after('title')->index();
            $table->enum('contact_type', ['office_visit', 'phone_call', 'other'])->default('office_visit')->after('service_section')->index();
            $table->text('purpose')->nullable()->after('contact_type');
            $table->text('follow_up_notes')->nullable()->after('purpose');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->after('is_sent')->index();
            $table->timestamp('completed_at')->nullable()->after('status');
            $table->index(['customer_id', 'remind_at']);
            $table->index(['service_section', 'remind_at']);
        });
    }

    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropIndex(['customer_id', 'remind_at']);
            $table->dropIndex(['service_section', 'remind_at']);
            $table->dropConstrainedForeignId('customer_id');
            $table->dropColumn(['service_section', 'contact_type', 'purpose', 'follow_up_notes', 'status', 'completed_at']);
        });
    }
};
