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
        Schema::create('bank_asia_ac_creations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            
            // Dates & Names
            $table->date('date');
            $table->string('applicant_name_en');
            $table->string('applicant_name_bn');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('spouse_name')->nullable();
            $table->date('date_of_birth');
            $table->string('gender'); // male, female, other
            $table->string('nid_number');
            $table->string('nationality')->default('Bangladeshi');
            $table->string('religion');
            $table->string('occupation');
            $table->decimal('monthly_income', 15, 2)->nullable();
            $table->string('source_of_funds')->nullable();
            
            // Addresses & Contacts
            $table->text('present_address');
            $table->text('permanent_address');
            $table->string('mobile_number');
            $table->string('email')->nullable();
            
            // Nominee details
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->integer('nominee_share_percent')->default(100);
            $table->string('nominee_nid_dob')->nullable();
            
            // Document uploads
            $table->string('applicant_photo_path')->nullable();
            $table->string('applicant_nid_front_path')->nullable();
            $table->string('applicant_nid_back_path')->nullable();
            $table->string('applicant_signature_path')->nullable();
            $table->string('nominee_photo_path')->nullable();
            
            // Status
            $table->string('status')->default('pending'); // pending, submitted, approved, rejected
            
            // Agent details
            $table->string('agent_name')->nullable();
            $table->string('agent_designation')->nullable();
            $table->string('agent_mobile')->nullable();
            $table->string('outlet_name_address')->nullable();
            
            $table->timestamps();
            
            $table->index('company_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_asia_ac_creations');
    }
};
