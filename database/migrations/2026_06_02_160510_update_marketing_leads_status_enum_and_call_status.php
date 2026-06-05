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
        // 1. Expand the ENUM to include old AND new values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE computer_training_marketing_leads MODIFY COLUMN status ENUM('new', 'contacted', 'contacting', 'interested', 'admitted', 'lost', 'not interested') DEFAULT 'new'");

        // 2. Update existing data
        \Illuminate\Support\Facades\DB::table('computer_training_marketing_leads')->where('status', 'contacted')->update(['status' => 'contacting']);
        \Illuminate\Support\Facades\DB::table('computer_training_marketing_leads')->where('status', 'lost')->update(['status' => 'not interested']);

        // 3. Shrink the ENUM to only the new values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE computer_training_marketing_leads MODIFY COLUMN status ENUM('new', 'contacting', 'interested', 'admitted', 'not interested') DEFAULT 'new'");

        Schema::table('computer_training_marketing_leads', function (Blueprint $table) {
            $table->string('call_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Expand to old and new
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE computer_training_marketing_leads MODIFY COLUMN status ENUM('new', 'contacted', 'contacting', 'interested', 'admitted', 'lost', 'not interested') DEFAULT 'new'");

        // 2. Revert data
        \Illuminate\Support\Facades\DB::table('computer_training_marketing_leads')->where('status', 'contacting')->update(['status' => 'contacted']);
        \Illuminate\Support\Facades\DB::table('computer_training_marketing_leads')->where('status', 'not interested')->update(['status' => 'lost']);

        // 3. Shrink ENUM
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE computer_training_marketing_leads MODIFY COLUMN status ENUM('new', 'contacted', 'interested', 'admitted', 'lost') DEFAULT 'new'");

        Schema::table('computer_training_marketing_leads', function (Blueprint $table) {
            $table->dropColumn('call_status');
        });
    }
};
