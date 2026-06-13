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
use App\Models\Reminder;
use App\Exports\ComputerTrainingMarketingLeadExport;
use App\Imports\ComputerTrainingMarketingLeadImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ComputerTrainingController extends Controller
{
    public const COURSES = [
        'Basic Computer',
        'Office Application',
        'Graphic Design',
        'Web Development',
        'Freelancing',
        'Digital Marketing',
        'Diploma in software application',
    ];

    public function storeStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'admission_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['lead', 'admitted', 'active', 'completed', 'dropped'])],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        ComputerTrainingStudent::create($this->withCompany($request, $data));

        return back()->with('status', 'Student saved.');
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
                
                if (!$nameKey || empty($data[$nameKey])) continue;

                $phone = $phoneKey && isset($data[$phoneKey]) ? trim($data[$phoneKey]) : null;

                // Simple deduplication based on phone number if available
                $existing = null;
                if ($phone) {
                    $existing = \App\Models\ComputerTrainingMarketingLead::where('company_id', $companyId)
                                ->where('phone', $phone)
                                ->first();
                }

                if (!$existing) {
                    \App\Models\ComputerTrainingMarketingLead::create([
                        'company_id'        => $companyId,
                        'name'              => trim($data[$nameKey]),
                        'phone'             => $phone,
                        'interested_course' => $courseKey && isset($data[$courseKey]) ? trim($data[$courseKey]) : null,
                        'source'            => $sourceKey && isset($data[$sourceKey]) ? trim($data[$sourceKey]) : null,
                        'status'            => $statusKey && !empty($data[$statusKey]) ? strtolower(trim($data[$statusKey])) : 'new',
                    ]);
                    $importedCount++;
                }
            }

            return back()->with('status', "Successfully synced $importedCount new leads from Google Sheet.")->with('tab', 'marketing');

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
}
