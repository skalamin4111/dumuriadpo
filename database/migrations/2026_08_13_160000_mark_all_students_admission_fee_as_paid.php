<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\ComputerTrainingStudent;
use App\Models\ComputerTrainingFee;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (ComputerTrainingStudent::all() as $student) {
            $fee = $student->fees()
                ->where(function ($q) {
                    $q->where('fee_type', 'Admission')
                      ->orWhere('fee_type', 'Admission Fee')
                      ->orWhereNull('fee_type');
                })
                ->first();

            if ($fee) {
                $targetAmount = $fee->amount > 0 ? $fee->amount : 3000;
                $fee->update([
                    'fee_type' => 'Admission',
                    'amount' => $targetAmount,
                    'paid_amount' => $targetAmount,
                    'status' => 'paid',
                    'paid_at' => $fee->paid_at ?? now(),
                ]);
            } else {
                $student->fees()->create([
                    'company_id' => $student->company_id,
                    'fee_type' => 'Admission',
                    'amount' => 3000,
                    'paid_amount' => 3000,
                    'due_date' => $student->admission_date ?? now(),
                    'paid_at' => now(),
                    'status' => 'paid',
                    'payment_method' => 'Cash',
                    'remarks' => 'Initial Admission Fee (Paid)',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
