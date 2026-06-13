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
            $table->integer('regular_withdrawal_daily_count')->nullable()->after('regular_monthly_tx_amount');
            $table->decimal('regular_withdrawal_daily_amount', 15, 2)->nullable()->after('regular_withdrawal_daily_count');
            $table->integer('regular_withdrawal_monthly_count')->nullable()->after('regular_withdrawal_daily_amount');
            $table->decimal('regular_withdrawal_monthly_amount', 15, 2)->nullable()->after('regular_withdrawal_monthly_count');

            $table->integer('regular_transfer_daily_count')->nullable()->after('regular_withdrawal_monthly_amount');
            $table->decimal('regular_transfer_daily_amount', 15, 2)->nullable()->after('regular_transfer_daily_count');
            $table->integer('regular_transfer_monthly_count')->nullable()->after('regular_transfer_daily_amount');
            $table->decimal('regular_transfer_monthly_amount', 15, 2)->nullable()->after('regular_transfer_monthly_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_asia_tp_updates', function (Blueprint $table) {
            $table->dropColumn([
                'regular_withdrawal_daily_count',
                'regular_withdrawal_daily_amount',
                'regular_withdrawal_monthly_count',
                'regular_withdrawal_monthly_amount',
                'regular_transfer_daily_count',
                'regular_transfer_daily_amount',
                'regular_transfer_monthly_count',
                'regular_transfer_monthly_amount',
            ]);
        });
    }
};
