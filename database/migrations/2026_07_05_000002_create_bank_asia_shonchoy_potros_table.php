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
        Schema::create('bank_asia_shonchoy_potros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            
            // Purchaser Details
            $table->string('purchaser_name');
            $table->string('purchaser_nid');
            $table->string('purchaser_phone');
            $table->date('purchaser_dob');
            $table->text('purchaser_address');
            
            // Certificate Details
            $table->string('certificate_type'); // family, 3_month_interest, pensioner, 5_year_bd
            $table->string('certificate_number');
            $table->string('registration_number');
            $table->date('purchase_date');
            $table->date('maturity_date');
            $table->decimal('purchase_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2)->nullable();
            
            // Nominee Details
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->integer('nominee_share_percent')->default(100);
            
            // Status & Documents
            $table->string('status')->default('active'); // active, matured, encashed
            $table->string('document_path')->nullable(); // Certificate photocopy scan
            $table->text('notes')->nullable();
            
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
        Schema::dropIfExists('bank_asia_shonchoy_potros');
    }
};
