<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ComputerTrainingAttendance;
use App\Models\ComputerTrainingStudent;
use App\Models\ComputerTrainingBatch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ComputerTrainingAttendanceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_attendance_defaults_to_diploma_in_software_application(): void
    {
        $company = \App\Models\Company::first() ?: \App\Models\Company::create([
            'uuid' => (string) str()->uuid(),
            'name' => 'Test Company',
            'plan' => 'enterprise',
            'status' => 'active',
            'timezone' => 'UTC',
            'locale' => 'en',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'name' => 'Admin User',
            'email' => 'admin_test_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $batch = ComputerTrainingBatch::create([
            'company_id' => $company->id,
            'name' => 'Batch 1',
            'type' => 'regular',
        ]);

        // Student with default course
        $student1 = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1001',
            'name' => 'John Doe',
            'phone' => '01712345678',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // Student with different course
        $student2 = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1002',
            'name' => 'Jane Doe',
            'phone' => '01712345679',
            'course' => 'Graphics Design',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // Attendance records
        $attendance1 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student1->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'present',
        ]);

        $attendance2 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student2->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'present',
        ]);

        // Act & Assert
        $response = $this->actingAs($user)
            ->get('/services/computer-training?tab=attendance');

        $response->assertStatus(200);
        
        $records = $response->viewData('attendanceRecords');
        $this->assertNotNull($records);
        
        // Assert only student1's attendance is returned since Diploma in Software Application is default filter
        $recordIds = collect($records->items())->pluck('id')->toArray();
        $this->assertContains($attendance1->id, $recordIds);
        $this->assertNotContains($attendance2->id, $recordIds);

        // Verify that all returned records are filtered by the default course
        foreach ($records->items() as $record) {
            $this->assertEquals('Diploma in Software Application', $record->student->course);
        }

        // Act with explicit attendance_course set to empty (All Courses)
        $responseAll = $this->actingAs($user)
            ->get('/services/computer-training?tab=attendance&attendance_course=');

        $responseAll->assertStatus(200);
        $recordsAll = $responseAll->viewData('attendanceRecords');
        $recordIdsAll = collect($recordsAll->items())->pluck('id')->toArray();
        // Both students' records should be returned
        $this->assertContains($attendance1->id, $recordIdsAll);
        $this->assertContains($attendance2->id, $recordIdsAll);
    }
}
