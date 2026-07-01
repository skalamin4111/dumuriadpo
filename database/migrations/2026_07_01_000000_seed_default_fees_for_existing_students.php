<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
            if ($student->fees()->count() === 0) {
                $student->fees()->create([
                    'company_id' => $student->company_id,
                    'fee_type' => 'Admission Fee',
                    'amount' => 3000,
                    'paid_amount' => 1000,
                    'due_date' => $student->admission_date ?? now(),
                    'status' => 'partial',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op or we could delete the seeded fees
    }
};
