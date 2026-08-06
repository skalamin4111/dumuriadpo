<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ComputerTrainingAttendance;
use App\Models\ComputerTrainingBatch;
use App\Models\ComputerTrainingStudent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ComputerTrainingAttendanceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_attendance_defaults_to_diploma_in_software_application(): void
    {
        $company = Company::first() ?: Company::create([
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
            'email' => 'admin_test_'.uniqid().'@example.com',
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

    public function test_daily_rank_can_be_saved_and_updated(): void
    {
        $company = Company::first() ?: Company::create([
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
            'email' => 'admin_test_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $batch = ComputerTrainingBatch::create([
            'company_id' => $company->id,
            'name' => 'Batch 1',
            'type' => 'regular',
        ]);

        $student = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1003',
            'name' => 'Test Student',
            'phone' => '01712345670',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // Bulk store with daily_rank
        $responseBulk = $this->actingAs($user)->post('/services/computer-training/attendance/bulk', [
            'batch_id' => $batch->id,
            'attendance_date' => now()->toDateString(),
            'attendances' => [
                [
                    'student_id' => $student->id,
                    'status' => 'present',
                    'daily_rank' => 1,
                ],
            ],
        ]);

        $responseBulk->assertRedirect();

        $attendance = ComputerTrainingAttendance::where('student_id', $student->id)->first();
        $this->assertNotNull($attendance);
        $this->assertEquals(1, $attendance->daily_rank);

        // Update daily_rank
        $responseUpdate = $this->actingAs($user)->put("/services/computer-training/attendance/{$attendance->id}", [
            'status' => 'present',
            'daily_rank' => 2,
        ]);

        $responseUpdate->assertRedirect();

        $attendance->refresh();
        $this->assertEquals(2, $attendance->daily_rank);
    }

    public function test_marks_calculations(): void
    {
        $company = Company::first() ?: Company::create([
            'uuid' => (string) str()->uuid(),
            'name' => 'Test Company',
            'plan' => 'enterprise',
            'status' => 'active',
            'timezone' => 'UTC',
            'locale' => 'en',
        ]);

        $batch = ComputerTrainingBatch::create([
            'company_id' => $company->id,
            'name' => 'Batch 1',
            'type' => 'regular',
        ]);

        $student = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1004',
            'name' => 'Marks Student',
            'phone' => '01712345671',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // 1. Standard Present (5 marks)
        $att1 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->subDays(5)->toDateString(),
            'status' => 'present',
        ]);
        $this->assertEquals(5, $att1->today_mark);

        // 2. Present with Rank 1 (10 marks)
        $att2 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->subDays(4)->toDateString(),
            'status' => 'present',
            'daily_rank' => 1,
        ]);
        $this->assertEquals(10, $att2->today_mark);

        // 3. Present with Rank 2 (5 marks)
        $att3 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->subDays(3)->toDateString(),
            'status' => 'present',
            'daily_rank' => 2,
        ]);
        $this->assertEquals(5, $att3->today_mark);

        // 4. Present with Rank 3 (3 marks)
        $att4 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->subDays(2)->toDateString(),
            'status' => 'present',
            'daily_rank' => 3,
        ]);
        $this->assertEquals(3, $att4->today_mark);

        // 5. Late (5 marks)
        $att5 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->subDays(1)->toDateString(),
            'status' => 'late',
        ]);
        $this->assertEquals(5, $att5->today_mark);

        // 6. Absent (-2 marks)
        $att6 = ComputerTrainingAttendance::create([
            'company_id' => $company->id,
            'student_id' => $student->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'absent',
        ]);
        $this->assertEquals(-2, $att6->today_mark);

        // Total calculated marks should be: 5 + 10 + 5 + 3 + 5 - 2 = 26
        $this->assertEquals(26, $student->total_marks);
    }

    public function test_skip_unmarked_allows_submitting_without_all_students_marked(): void
    {
        $company = Company::first() ?: Company::create([
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
            'email' => 'admin_test_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $batch = ComputerTrainingBatch::create([
            'company_id' => $company->id,
            'name' => 'Batch 1',
            'type' => 'regular',
        ]);

        $student1 = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1005',
            'name' => 'Marked Student',
            'phone' => '01712345672',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        $student2 = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1006',
            'name' => 'Unmarked Student',
            'phone' => '01712345673',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // With skip_unmarked, student2 is left without a status.
        $response = $this->actingAs($user)->post('/services/computer-training/attendance/bulk', [
            'batch_id' => $batch->id,
            'attendance_date' => now()->toDateString(),
            'skip_unmarked' => '1',
            'attendances' => [
                [
                    'student_id' => $student1->id,
                    'status' => 'present',
                ],
                [
                    'student_id' => $student2->id,
                ],
            ],
        ]);

        $response->assertRedirect();

        $this->assertEquals('present', ComputerTrainingAttendance::where('student_id', $student1->id)->value('status'));
        $this->assertNull(ComputerTrainingAttendance::where('student_id', $student2->id)->first());
    }

    public function test_skip_unmarked_disabled_requires_all_statuses(): void
    {
        $company = Company::first() ?: Company::create([
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
            'email' => 'admin_test_'.uniqid().'@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $batch = ComputerTrainingBatch::create([
            'company_id' => $company->id,
            'name' => 'Batch 1',
            'type' => 'regular',
        ]);

        $student = ComputerTrainingStudent::create([
            'company_id' => $company->id,
            'student_id' => '1007',
            'name' => 'Required Student',
            'phone' => '01712345674',
            'course' => 'Diploma in Software Application',
            'batch_id' => $batch->id,
            'admission_date' => now()->toDateString(),
            'status' => 'admitted',
        ]);

        // Without skip_unmarked, a missing status must be rejected.
        $response = $this->actingAs($user)->post('/services/computer-training/attendance/bulk', [
            'batch_id' => $batch->id,
            'attendance_date' => now()->toDateString(),
            'attendances' => [
                [
                    'student_id' => $student->id,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('attendances.0.status');
        $this->assertNull(ComputerTrainingAttendance::where('student_id', $student->id)->first());
    }
}
