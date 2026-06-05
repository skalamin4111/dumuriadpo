<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('new','assigned','in_progress','on_hold','pending_review','pending_approval','completed','rejected','cancelled','overdue') DEFAULT 'new'");
    }

    public function down(): void
    {
        DB::statement("UPDATE tasks SET status = 'pending_approval' WHERE status = 'pending_review'");
        DB::statement("UPDATE tasks SET status = 'cancelled' WHERE status = 'rejected'");
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('new','assigned','in_progress','on_hold','completed','pending_approval','cancelled','overdue') DEFAULT 'new'");
    }
};
