<?php

namespace App\Http\Controllers\Web;

use App\Exports\ComputerTrainingMarketingLeadExport;
use App\Http\Controllers\Controller;
use App\Imports\ComputerTrainingMarketingLeadImport;
use App\Jobs\SendWhatsAppNoticeJob;
use App\Models\ComputerTrainingAdvanceAbsence;
use App\Models\ComputerTrainingAttendance;
use App\Models\ComputerTrainingBatch;
use App\Models\ComputerTrainingClassSchedule;
use App\Models\ComputerTrainingCourse;
use App\Models\ComputerTrainingExam;
use App\Models\ComputerTrainingFee;
use App\Models\ComputerTrainingMarketingLead;
use App\Models\ComputerTrainingNotice;
use App\Models\ComputerTrainingStudent;
use App\Models\Reminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

    public function syncAdmittedStudents(Request $request): RedirectResponse
    {
        $sheetId = '1ca1k65_IuGOGHgbJQTNKbVkqzLk1CH9Lizu5exDOLIs';
        $gid = '1676498509';
        $csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid={$gid}";

        try {
            $response = Http::get($csvUrl);

            // Google sometimes returns an HTML page (login/redirect) instead of CSV.
            if (! $response->successful() || str_contains($response->body(), '<!DOCTYPE html>')) {
                return back()->withErrors(['google_sheet' => 'Could not access the Google Sheet. Please ensure its sharing settings are set to "Anyone with the link can view".'])->with('tab', 'students');
            }

            $rows = array_map('str_getcsv', explode("\n", trim($response->body())));
            if (count($rows) < 2) {
                return back()->with('status', 'Google Sheet is empty or invalid.')->with('tab', 'students');
            }

            // Normalize headers so the column mapping always follows the actual
            // Google Sheet layout, no matter how the columns are ordered/named.
            $header = array_shift($rows);
            $header = array_map(fn ($h) => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $h), '_')), $header);

            $col = fn (array $keys) => collect($header)->first(fn ($key) => in_array($key, $keys));

            $serialKey = $col(['serial_no', 'serial', 'no', 'sl_no', 'serial_number']);
            $batchKey = $col(['batch', 'batch_name', 'batch_no']);
            $nameKey = $col(['student_name', 'name', 'full_name', 'student']);
            $fatherKey = $col(['father_s_name', 'fathers_name', 'father_name', 'father']);
            $motherKey = $col(['mother_s_name', 'mothers_name', 'mother_name', 'mother']);
            $schoolKey = $col(['school_name', 'school']);
            $dobKey = $col(['date_of_birth', 'dob', 'birth_date']);
            $rollKey = $col(['roll_number', 'roll_no', 'roll']);
            $regKey = $col(['registration_number', 'reg_no', 'registration', 'reg', 'reg_number']);
            $mobileKey = $col(['mobile_number', 'mobile', 'phone', 'phone_number', 'contact', 'mobile_no']);

            $getVal = function (array $data, $key) {
                return $key !== null ? trim($data[$key] ?? '') : '';
            };

            $companyId = $request->user() ? $request->user()->company_id : 1;
            $session = date('Y').'-2';
            $syncedCount = 0;
            $touchedThisRun = [];
            $touchedBatchIds = [];

            foreach ($rows as $row) {
                if (count($header) !== count($row)) {
                    continue; // Skip malformed rows
                }
                $data = array_combine($header, $row);

                $sheetSerial = $getVal($data, $serialKey);
                $batchName = $getVal($data, $batchKey);
                $studentName = $getVal($data, $nameKey);
                $fatherName = $getVal($data, $fatherKey);
                $motherName = $getVal($data, $motherKey);
                $schoolName = $getVal($data, $schoolKey);
                $dob = $getVal($data, $dobKey);
                $rollNo = $getVal($data, $rollKey);
                $regNo = $getVal($data, $regKey);
                $mobile = $getVal($data, $mobileKey);

                if (empty($studentName)) {
                    continue;
                }

                // Auto-create the batch exactly as named in the Google Sheet.
                $batchId = null;
                if ($batchName !== '') {
                    $batch = ComputerTrainingBatch::firstOrCreate(
                        ['company_id' => $companyId, 'name' => $batchName],
                        [
                            'type' => $this->inferBatchType($batchName),
                            'capacity' => 15,
                            'status' => 'active',
                        ]
                    );
                    $batchId = $batch->id;
                    $touchedBatchIds[] = $batch->id;
                }

                // Store the exact sheet values (School/Mother/DOB/Roll/Reg) in notes.
                $notes = [];
                if ($schoolName) {
                    $notes[] = 'School: '.$schoolName;
                }
                if ($motherName) {
                    $notes[] = 'Mother: '.$motherName;
                }
                if ($dob) {
                    $notes[] = 'DOB: '.$dob;
                }
                if ($rollNo) {
                    $notes[] = 'Roll: '.$rollNo;
                }
                if ($regNo) {
                    $notes[] = 'Reg No: '.$regNo;
                }
                $notesString = implode("\n", $notes);

                $seatNumber = (is_numeric($sheetSerial) && $sheetSerial > 0) ? (int) $sheetSerial : null;

                // Match the existing student (most specific match first) so every
                // sync updates the exact student from the sheet instead of duplicating.
                $student = null;
                if ($studentName && $fatherName) {
                    $student = ComputerTrainingStudent::where('company_id', $companyId)
                        ->where('name', $studentName)
                        ->where('guardian_name', $fatherName)
                        ->first();
                }
                if (! $student && $studentName) {
                    $student = ComputerTrainingStudent::where('company_id', $companyId)
                        ->where('name', $studentName)
                        ->first();
                }
                if (! $student && $mobile && $studentName) {
                    $student = ComputerTrainingStudent::where('company_id', $companyId)
                        ->where('phone', $mobile)
                        ->where('name', $studentName)
                        ->first();
                }
                // Phone-only fallback handles students whose sheet name differs from
                // the stored one (e.g. Bengali vs English spelling). It only matches
                // a unique phone and never a student already handled earlier in this
                // same sync, so two sheet rows sharing a phone stay separate.
                if (! $student && $mobile) {
                    $student = ComputerTrainingStudent::where('company_id', $companyId)
                        ->where('phone', $mobile)
                        ->whereNotIn('id', $touchedThisRun)
                        ->first();
                    if ($student) {
                        $phoneCount = ComputerTrainingStudent::where('company_id', $companyId)
                            ->where('phone', $mobile)
                            ->whereNotIn('id', $touchedThisRun)
                            ->count();
                        if ($phoneCount !== 1) {
                            $student = null;
                        }
                    }
                }

                $studentId = null;
                if ($seatNumber !== null) {
                    $candidateStudentId = substr(str_replace('-', '', $session), 2).str_pad($seatNumber, 2, '0', STR_PAD_LEFT);
                    $taken = ComputerTrainingStudent::where('company_id', $companyId)
                        ->where('student_id', $candidateStudentId)
                        ->where('id', '!=', $student?->id ?? 0)
                        ->exists();
                    if (! $taken) {
                        $studentId = $candidateStudentId;
                    }
                }

                $dataToSave = [
                    'name' => $studentName,
                    'father_name' => $fatherName,
                    'mother_name' => $motherName,
                    'guardian_name' => $fatherName,
                    'phone' => $mobile,
                    'batch_id' => $batchId,
                    'seat_number' => $seatNumber,
                    'student_id' => $studentId,
                    'notes' => $notesString,
                ];

                if ($student) {
                    $student->update($dataToSave);
                    $touchedThisRun[] = $student->id;
                } else {
                    $newStudent = ComputerTrainingStudent::create([
                        ...$dataToSave,
                        'company_id' => $companyId,
                        'course' => 'Diploma in Software Application',
                        'admission_date' => now(),
                        'session' => $session,
                        'status' => 'active',
                    ]);
                    $touchedThisRun[] = $newStudent->id;
                }

                $syncedCount++;
            }

            // Self-heal duplicates left behind by older syncs: any active students
            // that share the same name + phone + batch are the same person. Keep
            // the oldest record, re-attach attendance the keeper does not already
            // have, and soft-delete the extras.
            $duplicateGroups = ComputerTrainingStudent::select('name', 'phone', 'batch_id')
                ->where('company_id', $companyId)
                ->whereNotNull('phone')
                ->where('phone', '<>', '')
                ->whereNotNull('batch_id')
                ->whereNull('deleted_at')
                ->groupBy('name', 'phone', 'batch_id')
                ->havingRaw('COUNT(*) > 1')
                ->get();

            foreach ($duplicateGroups as $dup) {
                $group = ComputerTrainingStudent::where('company_id', $companyId)
                    ->where('name', $dup->name)
                    ->where('phone', $dup->phone)
                    ->where('batch_id', $dup->batch_id)
                    ->whereNull('deleted_at')
                    ->orderBy('id')
                    ->get();

                $keeper = $group->shift();
                if (! $keeper) {
                    continue;
                }

                foreach ($group as $extra) {
                    foreach ($extra->attendances as $attendance) {
                        $keeperHasDate = ComputerTrainingAttendance::where('student_id', $keeper->id)
                            ->where('attendance_date', $attendance->attendance_date)
                            ->exists();
                        if ($keeperHasDate) {
                            $attendance->delete();
                        } else {
                            $attendance->update(['student_id' => $keeper->id]);
                        }
                    }

                    foreach ($extra->advanceAbsences as $advanceAbsence) {
                        $advanceAbsence->update(['student_id' => $keeper->id]);
                    }

                    ComputerTrainingFee::where('student_id', $extra->id)->delete();

                    $extra->delete();
                }
            }

            // The Google Sheet is the single source of truth for students and
            // batches: remove (soft-delete) anything that no longer exists in the
            // sheet so the student list and batch dropdowns match it exactly.
            // Related records (attendance, fees, absences) are preserved, only the
            // student/batch rows are hidden. Guarded so an empty/malformed sync
            // run can never wipe the whole database.
            if (! empty($touchedThisRun)) {
                $staleStudents = ComputerTrainingStudent::where('company_id', $companyId)
                    ->whereNull('deleted_at')
                    ->whereNotIn('id', $touchedThisRun)
                    ->get();

                foreach ($staleStudents as $stale) {
                    $stale->delete();
                }
            }

            if (! empty($touchedBatchIds)) {
                ComputerTrainingBatch::where('company_id', $companyId)
                    ->whereNull('deleted_at')
                    ->whereNotIn('id', $touchedBatchIds)
                    ->delete();
            }

            return back()->with('status', "Successfully synced {$syncedCount} admitted students from Google Sheets.")->with('tab', 'students');

        } catch (\Exception $e) {
            Log::error('Google Sheets Sync Error: '.$e->getMessage());

            return back()->with('error', 'Error syncing data: '.$e->getMessage())->with('tab', 'students');
        }
    }

    private function inferBatchType(string $name): string
    {
        $upper = strtoupper(trim($name));
        if (str_starts_with($upper, 'R-')) {
            return 'R';
        }
        if (str_starts_with($upper, 'S-')) {
            return 'S';
        }

        return 'regular';
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
            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
            'batch_name' => ['nullable', 'string', 'max:255'],
            'class_number' => ['nullable', 'string', 'max:255'],
            'instructor' => ['nullable', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'class_date' => ['required', 'date'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['nullable', 'date_format:H:i'],
            'topic' => ['nullable', 'string'],
        ]);

        if (! empty($data['batch_id'])) {
            $batch = ComputerTrainingBatch::find($data['batch_id']);
            if ($batch) {
                $data['batch_name'] = $batch->name;
            }
        }

        if (empty($data['ends_at'])) {
            $data['ends_at'] = $data['starts_at'];
        }

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
            'fee_type' => ['required', 'string'],
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

    public function getStudentsFees(Request $request)
    {
        $companyId = $request->user()?->company_id;
        $batchId = $request->input('batch_id');
        $feeType = $request->input('fee_type', 'Admission');
        $course = $request->input('course');

        $query = ComputerTrainingStudent::query();
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        if ($batchId && $batchId !== 'all' && $batchId !== '') {
            $query->where('batch_id', $batchId);
        }

        if ($course && $course !== 'all' && $course !== '') {
            $query->where('course', $course);
        }

        $students = $query->with(['fees' => fn ($q) => $q->where('fee_type', $feeType)])
            ->orderBy('name')
            ->get()
            ->map(function ($s) use ($feeType) {
                $fee = $s->fees->first();
                $totalAmount = $fee ? (float) $fee->amount : 3000.00;
                $paidAmount = $fee ? (float) $fee->paid_amount : 0.00;
                $dueAmount = max(0, $totalAmount - $paidAmount);

                return [
                    'id' => $s->id,
                    'student_id' => $s->student_id ?? 'N/A',
                    'name' => $s->name,
                    'phone' => $s->phone ?? '-',
                    'course' => $s->course,
                    'existing_fee_id' => $fee?->id,
                    'total_amount' => $totalAmount,
                    'paid_amount' => $paidAmount,
                    'due_amount' => $dueAmount,
                    'collecting_amount' => $dueAmount,
                    'selected' => $dueAmount > 0,
                    'status' => $fee?->status ?? ($dueAmount > 0 ? 'due' : 'paid'),
                ];
            });

        return response()->json(['students' => $students]);
    }

    public function storeBulkFees(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fee_type' => ['required', 'string'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'fees' => ['required', 'array', 'min:1'],
            'fees.*.student_id' => ['required', 'exists:computer_training_students,id'],
            'fees.*.collecting_amount' => ['required', 'numeric', 'min:0.01'],
            'fees.*.total_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $companyId = $request->user()?->company_id;
        $count = 0;

        DB::transaction(function () use ($data, $companyId, &$count) {
            foreach ($data['fees'] as $item) {
                $studentId = $item['student_id'];
                $collecting = (float) $item['collecting_amount'];

                if ($collecting <= 0) {
                    continue;
                }

                $existingFee = ComputerTrainingFee::where('student_id', $studentId)
                    ->where('fee_type', $data['fee_type'])
                    ->latest()
                    ->first();

                if ($existingFee) {
                    $newPaid = (float) $existingFee->paid_amount + $collecting;
                    $totalAmount = (float) $existingFee->amount;
                    $status = ($newPaid >= $totalAmount) ? 'paid' : (($newPaid > 0) ? 'partial' : 'due');

                    $existingFee->update([
                        'paid_amount' => $newPaid,
                        'paid_at' => $data['payment_date'],
                        'status' => $status,
                        'payment_method' => $data['payment_method'] ?? $existingFee->payment_method,
                        'remarks' => !empty($data['remarks'])
                            ? trim(($existingFee->remarks ?? '') . "\nBulk Collection (" . $data['payment_date'] . "): " . $data['remarks'])
                            : $existingFee->remarks,
                    ]);
                } else {
                    $totalAmount = isset($item['total_amount']) && (float) $item['total_amount'] > 0
                        ? (float) $item['total_amount']
                        : 3000.00;

                    $status = ($collecting >= $totalAmount) ? 'paid' : 'partial';

                    ComputerTrainingFee::create([
                        'company_id' => $companyId,
                        'student_id' => $studentId,
                        'fee_type' => $data['fee_type'],
                        'amount' => $totalAmount,
                        'paid_amount' => $collecting,
                        'due_date' => $data['payment_date'],
                        'paid_at' => $data['payment_date'],
                        'status' => $status,
                        'payment_method' => $data['payment_method'] ?? 'Cash',
                        'remarks' => $data['remarks'] ?? null,
                    ]);
                }

                $count++;
            }
        });

        return back()->with('status', "Bulk fee collection successfully processed for {$count} student(s).")->with('tab', 'fees');
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
            if (! empty($lead->phone)) {
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
                    'notes' => ltrim(($lead->notes."\n".$lead->remarks), "\n"),
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
            return back()->withErrors(['file' => 'Error importing file: '.$e->getMessage()])->with('tab', 'marketing');
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
            'is_active' => ['nullable', 'boolean'],
            'send_whatsapp' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'target_type' => ['required', Rule::in(['all', 'course', 'batch', 'student'])],
            'target_course' => ['nullable', 'string', 'required_if:target_type,course'],
            'target_batch_id' => ['nullable', 'exists:computer_training_batches,id', 'required_if:target_type,batch'],
            'target_student_id' => ['nullable', 'exists:computer_training_students,id', 'required_if:target_type,student'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $sendWhatsapp = $request->boolean('send_whatsapp', false);

        if ($data['target_type'] === 'all') {
            $data['audience'] = 'all';
        } else {
            $data['audience'] = 'students';
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('notices', 'public');
        }

        if ($data['target_type'] !== 'course') {
            $data['target_course'] = null;
        }
        if ($data['target_type'] !== 'batch') {
            $data['target_batch_id'] = null;
        }
        if ($data['target_type'] !== 'student') {
            $data['target_student_id'] = null;
        }

        $notice = ComputerTrainingNotice::create($this->withCompany($request, $data));

        if ($sendWhatsapp) {
            $query = ComputerTrainingStudent::query()
                ->where('company_id', $request->user() ? $request->user()->company_id : 1)
                ->whereNotNull('phone');

            if ($data['target_type'] === 'course') {
                $query->where('course', $data['target_course']);
            } elseif ($data['target_type'] === 'batch') {
                $query->where('batch_id', $data['target_batch_id']);
            } elseif ($data['target_type'] === 'student') {
                $query->where('id', $data['target_student_id']);
            }

            $phoneNumbers = $query->pluck('phone')->toArray();

            if (! empty($phoneNumbers)) {
                SendWhatsAppNoticeJob::dispatch($notice, $phoneNumbers);
            }
        }

        return back()->with('status', 'Notice published.');
    }

    public function syncGoogleSheet(Request $request): RedirectResponse
    {
        $sheetId = '1ca1k65_IuGOGHgbJQTNKbVkqzLk1CH9Lizu5exDOLIs';
        $gid = '0';
        $csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid={$gid}";

        try {
            $response = Http::get($csvUrl);

            // Check if Google returned an HTML page (like a login page) instead of CSV
            if (! $response->successful() || str_contains($response->body(), '<!DOCTYPE html>')) {
                return back()->withErrors(['google_sheet' => 'Could not access the Google Sheet. Please ensure its sharing settings are set to "Anyone with the link can view".'])->with('tab', 'marketing');
            }

            $rows = array_map('str_getcsv', explode("\n", trim($response->body())));
            if (count($rows) < 2) {
                return back()->with('status', 'Google Sheet is empty or invalid.')->with('tab', 'marketing');
            }

            $header = array_shift($rows);
            // lowercase and slugify headers for easier matching
            $header = array_map(fn ($h) => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $h), '_')), $header);

            $companyId = $request->user()?->company_id;
            $importedCount = 0;
            $syncedLeadIds = [];

            foreach ($rows as $row) {
                if (count($header) !== count($row)) {
                    continue; // Skip malformed rows
                }
                $data = array_combine($header, $row);

                $nameKey = collect($header)->first(fn ($key) => in_array($key, ['student_name', 'name', 'full_name', 'student', 'lead_name']));
                $phoneKey = collect($header)->first(fn ($key) => in_array($key, ['mobile_number', 'phone', 'mobile', 'contact', 'phone_number']));
                $courseKey = collect($header)->first(fn ($key) => in_array($key, ['interested_course', 'course', 'program']));
                $sourceKey = collect($header)->first(fn ($key) => in_array($key, ['school_name', 'source', 'school']));
                $statusKey = collect($header)->first(fn ($key) => in_array($key, ['status', 'state']));
                $commentKey = collect($header)->first(fn ($key) => in_array($key, ['comment', 'comments', 'note', 'notes', 'remark', 'remarks']));

                if (! $nameKey || empty($data[$nameKey])) {
                    continue;
                }

                $name = trim($data[$nameKey]);
                $phone = $phoneKey && ! empty($data[$phoneKey]) ? trim($data[$phoneKey]) : null;

                $commentValue = $commentKey && ! empty($data[$commentKey]) ? trim($data[$commentKey]) : null;

                $validStatuses = ['new', 'contacting', 'interested', 'admitted', 'not interested'];
                $statusValue = 'new';

                if (! empty($commentValue)) {
                    $potentialStatus = strtolower($commentValue);
                    if (in_array($potentialStatus, $validStatuses)) {
                        $statusValue = $potentialStatus;
                    } else {
                        // If it's arbitrary text (like a note), fallback to 'contacting' to avoid MySQL errors.
                        $statusValue = 'contacting';
                    }
                } elseif ($statusKey && ! empty($data[$statusKey])) {
                    $potentialStatus = strtolower(trim($data[$statusKey]));
                    if (in_array($potentialStatus, $validStatuses)) {
                        $statusValue = $potentialStatus;
                    }
                }

                // Deduplication based on phone if available, otherwise fallback to name
                $existing = null;
                if ($phone) {
                    $existing = ComputerTrainingMarketingLead::where('company_id', $companyId)
                        ->where('phone', $phone)
                        ->first();
                } else {
                    $existing = ComputerTrainingMarketingLead::where('company_id', $companyId)
                        ->where('name', $name)
                        ->first();
                }

                if (! $existing) {
                    $lead = ComputerTrainingMarketingLead::create([
                        'company_id' => $companyId,
                        'name' => $name,
                        'phone' => $phone,
                        'interested_course' => $courseKey && isset($data[$courseKey]) ? trim($data[$courseKey]) : null,
                        'source' => $sourceKey && isset($data[$sourceKey]) ? trim($data[$sourceKey]) : null,
                        'status' => $statusValue,
                        'notes' => $commentValue,
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
                ComputerTrainingMarketingLead::where('company_id', $companyId)
                    ->whereNotIn('id', $syncedLeadIds)
                    ->delete();
            } else {
                // If the sheet was completely empty of valid leads, clear everything
                ComputerTrainingMarketingLead::where('company_id', $companyId)->delete();
            }

            return back()->with('status', 'Successfully synced Google Sheet. Only current Google Sheet leads are kept.')->with('tab', 'marketing');

        } catch (\Exception $e) {
            return back()->withErrors(['google_sheet' => 'Error syncing Google Sheet: '.$e->getMessage()])->with('tab', 'marketing');
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

    public function storeAdvanceAbsence(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:computer_training_students,id'],
            'absence_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $companyId = $request->user() ? $request->user()->company_id : 1;

        ComputerTrainingAdvanceAbsence::updateOrCreate(
            [
                'company_id' => $companyId,
                'student_id' => $data['student_id'],
                'absence_date' => $data['absence_date'],
            ],
            ['notes' => $data['notes'] ?? null]
        );

        return back()->with('status', 'Advance absence recorded. Student won\'t lose marks for this date.');
    }

    public function destroyAdvanceAbsence(Request $request, ComputerTrainingAdvanceAbsence $advanceAbsence): RedirectResponse
    {
        if ($request->user() && $advanceAbsence->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $advanceAbsence->delete();

        return back()->with('status', 'Advance absence note removed.');
    }

    public function getBatchStudents(Request $request, ComputerTrainingBatch $batch)
    {
        if ($request->user() && $batch->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $date = $request->input('date', now()->toDateString());

        // Fetch students with pre-aggregated counts for performance and marks calculation
        $students = $batch->students()
            ->withCount([
                'attendances as present_count' => fn ($q) => $q->where('status', 'present'),
                'attendances as absent_count' => fn ($q) => $q->where('status', 'absent'),
                'attendances as late_count' => fn ($q) => $q->where('status', 'late'),
                'attendances as rank_1_count' => fn ($q) => $q->where('daily_rank', 1),
                'attendances as rank_2_count' => fn ($q) => $q->where('daily_rank', 2),
                'attendances as rank_3_count' => fn ($q) => $q->where('daily_rank', 3),
                'attendances as advance_absence_count' => fn ($q) => $q->where('is_advance_absence', true),
            ])
            ->orderBy('student_id')
            ->get();

        $studentIds = $students->pluck('id')->toArray();

        // Query the most recent attendance record before the selected date for each student
        $prevStatuses = ComputerTrainingAttendance::whereIn('student_id', $studentIds)
            ->where('attendance_date', '<', $date)
            ->orderBy('attendance_date', 'desc')
            ->get()
            ->groupBy('student_id')
            ->map(fn ($group) => $group->first()->status);

        // Load advance absences for the selected date
        $advanceAbsences = ComputerTrainingAdvanceAbsence::whereIn('student_id', $studentIds)
            ->where('absence_date', $date)
            ->get()
            ->keyBy('student_id');

        // Attach previous status and advance absence info as model attributes
        foreach ($students as $student) {
            $student->setAttribute('prev_status', $prevStatuses->get($student->id, null));
            $aa = $advanceAbsences->get($student->id);
            $student->setAttribute('advance_absence_note', $aa?->notes);
            $student->setAttribute('has_advance_absence', $aa ? true : false);
        }

        return response()->json([
            'students' => $students,
        ]);
    }

    public function storeBulkAttendance(Request $request): RedirectResponse
    {
        $skipUnmarked = $request->boolean('skip_unmarked');

        $data = $request->validate([
            'batch_id' => ['required', 'exists:computer_training_batches,id'],
            'attendance_date' => ['required', 'date'],
            'attendances' => ['required', 'array'],
            'attendances.*.student_id' => ['required', 'exists:computer_training_students,id'],
            'attendances.*.status' => $skipUnmarked
                ? ['nullable', Rule::in(['present', 'absent', 'late'])]
                : ['required', Rule::in(['present', 'absent', 'late'])],
            'attendances.*.daily_rank' => ['nullable', 'integer', 'in:1,2,3'],
            'attendances.*.remarks' => ['nullable', 'string', 'max:255'],
            'skip_unmarked' => ['nullable', 'boolean'],
        ]);

        $companyId = $request->user() ? $request->user()->company_id : 1;

        // Load advance absences for the given date
        $studentIds = collect($data['attendances'])->pluck('student_id');
        $advanceAbsences = ComputerTrainingAdvanceAbsence::whereIn('student_id', $studentIds)
            ->where('absence_date', $data['attendance_date'])
            ->get()
            ->keyBy('student_id');

        foreach ($data['attendances'] as $att) {
            // When the user opted into partial attendance, skip any student
            // that was left unmarked so the submission still goes through.
            if ($skipUnmarked && empty($att['status'])) {
                continue;
            }

            $status = $att['status'];
            $dailyRank = $status === 'present' ? ($att['daily_rank'] ?? null) : null;
            $remarks = $status === 'absent' ? ($att['remarks'] ?? null) : null;
            $isAdvanceAbsence = $advanceAbsences->has($att['student_id']);

            ComputerTrainingAttendance::updateOrCreate(
                [
                    'company_id' => $companyId,
                    'student_id' => $att['student_id'],
                    'attendance_date' => $data['attendance_date'],
                ],
                [
                    'status' => $status,
                    'daily_rank' => $dailyRank,
                    'remarks' => $remarks,
                    'is_advance_absence' => $isAdvanceAbsence,
                ]
            );

            // If this attendance was marked, delete the advance absence record so it won't apply again
            if ($isAdvanceAbsence) {
                $advanceAbsences->get($att['student_id'])->delete();
            }
        }

        return back()->with('status', 'Bulk attendance recorded successfully.')->with('tab', 'attendance');
    }

    public function updateAttendance(Request $request, ComputerTrainingAttendance $attendance): RedirectResponse
    {
        if ($request->user() && $attendance->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['present', 'absent', 'late'])],
            'daily_rank' => ['nullable', 'integer', 'in:1,2,3'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'is_advance_absence' => ['nullable', 'boolean'],
        ]);

        if ($data['status'] === 'present') {
            $data['remarks'] = null;
            $data['is_advance_absence'] = false;
        } else {
            $data['daily_rank'] = null;
            $data['is_advance_absence'] = $request->boolean('is_advance_absence');
        }

        $attendance->update($data);

        return back()->with('status', 'Attendance record updated successfully.')->with('tab', 'attendance');
    }
}
