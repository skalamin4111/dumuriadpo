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
        Schema::table('bank_asia_ac_creations', function (Blueprint $table) {
            // Add new fields for Source of Fund form
            $table->string('account_type')->nullable()->after('date'); // new, dormant
            $table->string('account_number')->nullable()->after('mobile_number');
            $table->string('customer_id')->nullable()->after('account_number');

            // Make unnecessary fields nullable
            $table->string('applicant_name_en')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('nominee_name')->nullable()->change();
            $table->string('nominee_relation')->nullable()->change();
            $table->text('permanent_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_asia_ac_creations', function (Blueprint $table) {
            $table->dropColumn(['account_type', 'account_number', 'customer_id']);
            
            // Revert changes if necessary
            $table->string('applicant_name_en')->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('religion')->nullable(false)->change();
            $table->string('nominee_name')->nullable(false)->change();
            $table->string('nominee_relation')->nullable(false)->change();
            $table->text('permanent_address')->nullable(false)->change();
        });
    }
};
