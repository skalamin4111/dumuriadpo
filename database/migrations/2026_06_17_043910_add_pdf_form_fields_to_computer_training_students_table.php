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
        Schema::table('computer_training_students', function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
            $table->string('father_name')->nullable()->after('name_bn');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->date('date_of_birth')->nullable()->after('mother_name');
            $table->string('nid_or_birth_reg')->nullable()->after('date_of_birth');
            $table->string('nationality')->default('Bangladeshi')->nullable()->after('nid_or_birth_reg');
            $table->string('marital_status')->nullable()->after('nationality');
            $table->string('gender')->nullable()->after('marital_status');
            $table->string('religion')->nullable()->after('gender');
            $table->json('educational_qualifications')->nullable()->after('religion');
            $table->string('guardian_name')->nullable()->after('guardian_phone');
            $table->string('duration')->nullable()->after('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computer_training_students', function (Blueprint $table) {
            $table->dropColumn([
                'name_bn',
                'father_name',
                'mother_name',
                'date_of_birth',
                'nid_or_birth_reg',
                'nationality',
                'marital_status',
                'gender',
                'religion',
                'educational_qualifications',
                'guardian_name',
                'duration'
            ]);
        });
    }
};
