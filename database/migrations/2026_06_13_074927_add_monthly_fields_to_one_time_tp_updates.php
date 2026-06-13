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
        Schema::table('bank_asia_tp_updates', function (Blueprint $table) {
            $table->integer('one_time_cash_deposit_monthly_count')->nullable()->after('one_time_cash_deposit_amount');
            $table->decimal('one_time_cash_deposit_monthly_amount', 15, 2)->nullable()->after('one_time_cash_deposit_monthly_count');

            $table->integer('one_time_cash_withdrawal_monthly_count')->nullable()->after('one_time_cash_withdrawal_amount');
            $table->decimal('one_time_cash_withdrawal_monthly_amount', 15, 2)->nullable()->after('one_time_cash_withdrawal_monthly_count');

            $table->integer('one_time_transfer_monthly_count')->nullable()->after('one_time_transfer_amount');
            $table->decimal('one_time_transfer_monthly_amount', 15, 2)->nullable()->after('one_time_transfer_monthly_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_asia_tp_updates', function (Blueprint $table) {
            $table->dropColumn([
                'one_time_cash_deposit_monthly_count',
                'one_time_cash_deposit_monthly_amount',
                'one_time_cash_withdrawal_monthly_count',
                'one_time_cash_withdrawal_monthly_amount',
                'one_time_transfer_monthly_count',
                'one_time_transfer_monthly_amount',
            ]);
        });
    }
};
