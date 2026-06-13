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
        Schema::create('bank_asia_tp_updates', function (Blueprint $table) {
            $table->id();
            
            // Client details
            $table->string('account_number');
            $table->string('account_name');
            $table->string('account_type'); // savings, current, snd, other
            $table->date('date');
            
            // Undertaking details
            $table->integer('animal_quantity')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            
            // Limits - Regular
            $table->integer('regular_daily_tx_count')->nullable();
            $table->decimal('regular_daily_tx_amount', 15, 2)->nullable();
            $table->integer('regular_monthly_tx_count')->nullable();
            $table->decimal('regular_monthly_tx_amount', 15, 2)->nullable();

            // Limits - One Time
            $table->integer('one_time_cash_deposit_count')->nullable();
            $table->decimal('one_time_cash_deposit_amount', 15, 2)->nullable();
            $table->integer('one_time_cash_withdrawal_count')->nullable();
            $table->decimal('one_time_cash_withdrawal_amount', 15, 2)->nullable();
            $table->integer('one_time_transfer_count')->nullable();
            $table->decimal('one_time_transfer_amount', 15, 2)->nullable();

            // Additional fields
            $table->string('source_of_funds')->nullable();
            $table->string('client_mobile')->nullable();
            
            // Agent details
            $table->string('agent_name')->nullable();
            $table->string('agent_designation')->nullable();
            $table->string('agent_mobile')->nullable();
            $table->string('outlet_name_address')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_asia_tp_updates');
    }
};
