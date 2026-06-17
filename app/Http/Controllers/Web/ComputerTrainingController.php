<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ComputerTrainingAttendance;
use App\Models\ComputerTrainingClassSchedule;
use App\Models\ComputerTrainingExam;
use App\Models\ComputerTrainingFee;
use App\Models\ComputerTrainingMarketingLead;
use App\Models\ComputerTrainingNotice;
use App\Models\ComputerTrainingStudent;
use App\Models\ComputerTrainingBatch;
use App\Models\ComputerTrainingCourse;
use App\Models\Reminder;
use App\Exports\ComputerTrainingMarketingLeadExport;
use App\Imports\ComputerTrainingMarketingLeadImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ComputerTrainingController extends Controller
{


    public function storeStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'nid_or_birth_reg' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:255'],
            'educational_qualifications' => ['nullable', 'array'],
            'educational_qualifications.*.exam_name' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.group' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.institute' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.passing_year' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.board' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.grade' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:255'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'admission_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['lead', 'admitted', 'active', 'completed', 'dropped'])],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
            'seat_number' => ['nullable', 'integer', 'min:1', 'max:15', Rule::unique('computer_training_students')->where(function ($query) use ($request) {
                return $query->where('company_id', $request->user() ? $request->user()->company_id : 1)
                             ->where('batch_id', $request->batch_id);
            })],
        ]);

        ComputerTrainingStudent::create($this->withCompany($request, $data));

        return back()->with('status', 'Student saved.');
    }

    public function updateStudent(Request $request, ComputerTrainingStudent $student): RedirectResponse
    {
        if ($request->user() && $student->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'student_id' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'nid_or_birth_reg' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:255'],
            'educational_qualifications' => ['nullable', 'array'],
            'educational_qualifications.*.exam_name' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.group' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.institute' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.passing_year' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.board' => ['nullable', 'string', 'max:255'],
            'educational_qualifications.*.grade' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:255'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'admission_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['lead', 'admitted', 'active', 'completed', 'dropped'])],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
            'seat_number' => ['nullable', 'integer', 'min:1', 'max:15', Rule::unique('computer_training_students')->where(function ($query) use ($request) {
                return $query->where('company_id', $request->user() ? $request->user()->company_id : 1)
                             ->where('batch_id', $request->batch_id);
            })],
        ]);

        $student->update($data);

        return back()->with('status', 'Student updated successfully.');
    }

    public function destroyStudent(Request $request, ComputerTrainingStudent $student): RedirectResponse
    {
        if ($request->user() && $student->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $student->delete();

        return back()->with('status', 'Student deleted successfully.');
    }

    public function storeBatch(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:S,R'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'in:active,completed'],
        ]);

        ComputerTrainingBatch::create($this->withCompany($request, $data));

        return back()->with('status', 'Batch created successfully.')->with('tab', 'batches');
    }

    public function updateBatch(Request $request, ComputerTrainingBatch $batch): RedirectResponse
    {
        if ($request->user() && $batch->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:S,R'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'in:active,completed'],
        ]);

        $batch->update($data);

        return back()->with('status', 'Batch updated successfully.')->with('tab', 'batches');
    }

    public function destroyBatch(Request $request, ComputerTrainingBatch $batch): RedirectResponse
    {
        if ($request->user() && $batch->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $batch->delete();

        return back()->with('status', 'Batch deleted successfully.')->with('tab', 'batches');
    }

    public function storeAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:computer_training_students,id'],
            'class_schedule_id' => ['nullable', 'exists:computer_training_class_schedules,id'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['present', 'absent', 'late'])],
            'remarks' => ['nullable', 'string'],
        ]);

        ComputerTrainingAttendance::create($this->withCompany($request, $data));

        return back()->with('status', 'Attendance recorded.');
    }

    public function storeClassSchedule(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course' => ['required', 'string', 'max:255'],
            'batch_name' => ['required', 'string', 'max:255'],
            'instructor' => ['nullable', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'class_date' => ['required', 'date'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i'],
            'topic' => ['nullable', 'string'],
        ]);

        ComputerTrainingClassSchedule::create($this->withCompany($request, $data));

        return back()->with('status', 'Class schedule saved.');
    }

    public function storeExam(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'class_schedule_id' => ['nullable', 'exists:computer_training_class_schedules,id'],
            'title' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'exam_date' => ['required', 'date'],
            'starts_at' => ['nullable', 'date_format:H:i'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'syllabus' => ['nullable', 'string'],
        ]);

        ComputerTrainingExam::create($this->withCompany($request, $data));

        return back()->with('status', 'Exam scheduled.');
    }

    public function storeFee(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:computer_training_students,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'paid_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['due', 'partial', 'paid', 'waived'])],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);

        $data['paid_amount'] ??= 0;
        ComputerTrainingFee::create($this->withCompany($request, $data));

        return back()->with('status', 'Fee record saved.');
    }

    public function storeMarketingLead(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'interested_course' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['new', 'contacting', 'interested', 'admitted', 'not interested'])],
            'call_status' => ['nullable', 'string', 'max:255'],
            'next_follow_up_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        ComputerTrainingMarketingLead::create($this->withCompany($request, $data));

        return back()->with('status', 'Marketing lead saved.');
    }

    public function updateMarketingLead(Request $request, ComputerTrainingMarketingLead $lead): RedirectResponse
    {
        // Ensure the lead belongs to the user's company
        if ($request->user() && $lead->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'interested_course' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['new', 'contacting', 'interested', 'admitted', 'not interested'])],
            'call_status' => ['nullable', 'string', 'max:255'],
            'next_follow_up_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $lead->update($data);

        if ($data['status'] === 'admitted') {
            $studentSearchArgs = ['company_id' => $lead->company_id];
            if (!empty($lead->phone)) {
                $studentSearchArgs['phone'] = $lead->phone;
            } else {
                $studentSearchArgs['name'] = $lead->name;
            }

            ComputerTrainingStudent::firstOrCreate(
                $studentSearchArgs,
                [
                    'name' => $lead->name,
                    'phone' => $lead->phone,
                    'course' => $lead->interested_course ?? 'N/A',
                    'duration' => $lead->duration,
                    'status' => 'admitted',
                    'admission_date' => now()->toDateString(),
                    'notes' => ltrim(($lead->notes . "\n" . $lead->remarks), "\n"),
                ]
            );
        }

        return back()->with('status', 'Student updated successfully.')->with('tab', 'marketing');
    }

    public function exportMarketingLead(Request $request)
    {
        $companyId = $request->user()?->company_id;
        return Excel::download(new ComputerTrainingMarketingLeadExport($companyId), 'marketing_leads.xlsx');
    }

    public function importMarketingLead(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

        $companyId = $request->user()?->company_id;
        
        try {
            Excel::import(new ComputerTrainingMarketingLeadImport($companyId), $request->file('file'));
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error importing file: ' . $e->getMessage()])->with('tab', 'marketing');
        }

        return back()->with('status', 'Marketing leads imported successfully.')->with('tab', 'marketing');
    }

    public function storeReminder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'follow_up_notes' => ['nullable', 'string'],
            'remind_at' => ['required', 'date'],
        ]);

        Reminder::create([
            ...$data,
            'company_id' => $request->user()?->company_id,
            'user_id' => $request->user()->id,
            'service_section' => 'computer-training',
            'contact_type' => 'other',
            'status' => 'pending',
            'is_sent' => false,
        ]);

        return back()->with('status', 'Training reminder saved.');
    }

    public function storeNotice(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'publish_date' => ['required', 'date'],
            'audience' => ['required', Rule::in(['all', 'students', 'leads', 'staff'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        ComputerTrainingNotice::create($this->withCompany($request, $data));

        return back()->with('status', 'Notice published.');
    }

    public function syncGoogleSheet(Request $request): RedirectResponse
    {
        $sheetId = '1ca1k65_IuGOGHgbJQTNKbVkqzLk1CH9Lizu5exDOLIs';
        $gid = '0';
        $csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid={$gid}";

        try {
            $response = \Illuminate\Support\Facades\Http::get($csvUrl);
            
            // Check if Google returned an HTML page (like a login page) instead of CSV
            if (!$response->successful() || str_contains($response->body(), '<!DOCTYPE html>')) {
                return back()->withErrors(['google_sheet' => 'Could not access the Google Sheet. Please ensure its sharing settings are set to "Anyone with the link can view".'])->with('tab', 'marketing');
            }

            $rows = array_map('str_getcsv', explode("\n", trim($response->body())));
            if (count($rows) < 2) {
                return back()->with('status', 'Google Sheet is empty or invalid.')->with('tab', 'marketing');
            }

            $header = array_shift($rows);
            // lowercase and slugify headers for easier matching
            $header = array_map(fn($h) => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $h), '_')), $header);
            
            $companyId = $request->user()?->company_id;
            $importedCount = 0;
            $syncedLeadIds = [];

            foreach ($rows as $row) {
                if (count($header) !== count($row)) {
                    continue; // Skip malformed rows
                }
                $data = array_combine($header, $row);
                
                $nameKey = collect($header)->first(fn($key) => in_array($key, ['student_name', 'name', 'full_name', 'student', 'lead_name']));
                $phoneKey = collect($header)->first(fn($key) => in_array($key, ['mobile_number', 'phone', 'mobile', 'contact', 'phone_number']));
                $courseKey = collect($header)->first(fn($key) => in_array($key, ['interested_course', 'course', 'program']));
                $sourceKey = collect($header)->first(fn($key) => in_array($key, ['school_name', 'source', 'school']));
                $statusKey = collect($header)->first(fn($key) => in_array($key, ['status', 'state']));
                $commentKey = collect($header)->first(fn($key) => in_array($key, ['comment', 'comments', 'note', 'notes', 'remark', 'remarks']));
                
                if (!$nameKey || empty($data[$nameKey])) continue;

                $name = trim($data[$nameKey]);
                $phone = $phoneKey && !empty($data[$phoneKey]) ? trim($data[$phoneKey]) : null;

                $commentValue = $commentKey && !empty($data[$commentKey]) ? trim($data[$commentKey]) : null;
                
                $validStatuses = ['new', 'contacting', 'interested', 'admitted', 'not interested'];
                $statusValue = 'new';
                
                if (!empty($commentValue)) {
                    $potentialStatus = strtolower($commentValue);
                    if (in_array($potentialStatus, $validStatuses)) {
                        $statusValue = $potentialStatus;
                    } else {
                        // If it's arbitrary text (like a note), fallback to 'contacting' to avoid MySQL errors.
                        $statusValue = 'contacting';
                    }
                } elseif ($statusKey && !empty($data[$statusKey])) {
                    $potentialStatus = strtolower(trim($data[$statusKey]));
                    if (in_array($potentialStatus, $validStatuses)) {
                        $statusValue = $potentialStatus;
                    }
                }

                // Deduplication based on phone if available, otherwise fallback to name
                $existing = null;
                if ($phone) {
                    $existing = \App\Models\ComputerTrainingMarketingLead::where('company_id', $companyId)
                                ->where('phone', $phone)
                                ->first();
                } else {
                    $existing = \App\Models\ComputerTrainingMarketingLead::where('company_id', $companyId)
                                ->where('name', $name)
                                ->first();
                }

                if (!$existing) {
                    $lead = \App\Models\ComputerTrainingMarketingLead::create([
                        'company_id'        => $companyId,
                        'name'              => $name,
                        'phone'             => $phone,
                        'interested_course' => $courseKey && isset($data[$courseKey]) ? trim($data[$courseKey]) : null,
                        'source'            => $sourceKey && isset($data[$sourceKey]) ? trim($data[$sourceKey]) : null,
                        'status'            => $statusValue,
                        'notes'             => $commentValue,
                    ]);
                    $syncedLeadIds[] = $lead->id;
                    $importedCount++;
                } else {
                    $updateData = ['name' => $name];
                    if ($phone) {
                        $updateData['phone'] = $phone;
                    }
                    if ($courseKey && isset($data[$courseKey])) {
                        $updateData['interested_course'] = trim($data[$courseKey]);
                    }
                    if ($sourceKey && isset($data[$sourceKey])) {
                        $updateData['source'] = trim($data[$sourceKey]);
                    }
                    
                    $updateData['status'] = $statusValue;
                    if ($commentValue) {
                        $updateData['notes'] = $commentValue;
                    }
                    
                    $existing->update($updateData);
                    $syncedLeadIds[] = $existing->id;
                }
            }

            // Keep only Google Sheet data by deleting leads that were not in the current sync
            if (count($syncedLeadIds) > 0) {
                \App\Models\ComputerTrainingMarketingLead::where('company_id', $companyId)
                    ->whereNotIn('id', $syncedLeadIds)
                    ->delete();
            } else {
                // If the sheet was completely empty of valid leads, clear everything
                \App\Models\ComputerTrainingMarketingLead::where('company_id', $companyId)->delete();
            }

            return back()->with('status', "Successfully synced Google Sheet. Only current Google Sheet leads are kept.")->with('tab', 'marketing');

        } catch (\Exception $e) {
            return back()->withErrors(['google_sheet' => 'Error syncing Google Sheet: ' . $e->getMessage()])->with('tab', 'marketing');
        }
    }

    private function withCompany(Request $request, array $data): array
    {
        return [
            ...$data,
            'company_id' => $request->user()?->company_id,
        ];
    }

    public function storeCourse(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        ComputerTrainingCourse::create($this->withCompany($request, $data));

        return back()->with('status', 'Course created successfully.')->with('tab', 'batches');
    }

    public function updateCourse(Request $request, ComputerTrainingCourse $course): RedirectResponse
    {
        if ($request->user() && $course->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $course->update($data);

        return back()->with('status', 'Course updated successfully.')->with('tab', 'batches');
    }

    public function destroyCourse(Request $request, ComputerTrainingCourse $course): RedirectResponse
    {
        if ($request->user() && $course->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $course->delete();

        return back()->with('status', 'Course deleted successfully.')->with('tab', 'batches');
    }
    public function getBatchStudents(Request $request, ComputerTrainingBatch $batch)
    {
        if ($request->user() && $batch->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $students = $batch->students()->orderBy('seat_number')->get(['id', 'name', 'seat_number', 'phone', 'status']);
        
        return response()->json([
            'students' => $students
        ]);
    }

    public function storeBulkAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'batch_id' => ['required', 'exists:computer_training_batches,id'],
            'attendance_date' => ['required', 'date'],
            'attendances' => ['required', 'array'],
            'attendances.*.student_id' => ['required', 'exists:computer_training_students,id'],
            'attendances.*.status' => ['required', \Illuminate\Validation\Rule::in(['present', 'absent', 'late'])],
            'attendances.*.daily_rank' => ['nullable', 'integer', 'in:1,2,3'],
        ]);

        $companyId = $request->user() ? $request->user()->company_id : 1;

        foreach ($data['attendances'] as $att) {
            \App\Models\ComputerTrainingAttendance::updateOrCreate(
                [
                    'company_id' => $companyId,
                    'student_id' => $att['student_id'],
                    'attendance_date' => $data['attendance_date']
                ],
                [
                    'status' => $att['status'],
                    'daily_rank' => $att['daily_rank'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Bulk attendance recorded successfully.')->with('tab', 'attendance');
    }
}


