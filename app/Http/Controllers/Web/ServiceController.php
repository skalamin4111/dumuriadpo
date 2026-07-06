<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\ComputerTrainingController;
use App\Models\ComputerTrainingAttendance;
use App\Models\ComputerTrainingClassSchedule;
use App\Models\ComputerTrainingExam;
use App\Models\ComputerTrainingFee;
use App\Models\ComputerTrainingMarketingLead;
use App\Models\ComputerTrainingNotice;
use App\Models\ComputerTrainingStudent;
use App\Models\Reminder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function show(string $service): View|RedirectResponse
    {
        if (! array_key_exists($service, Reminder::SERVICES)) {
            return redirect()->route('dashboard');
        }

        if ($service === 'computer-training') {
            $perPage = request()->integer('per_page', 10);
            $attendanceCourse = request()->has('attendance_course') ? request('attendance_course') : 'Diploma in Software Application';

            return view('services.computer-training', [
                'attendanceRecords' => ComputerTrainingAttendance::with([
                    'student' => function ($query) {
                        $query->with(['batch'])->withCount([
                            'attendances as present_count' => fn ($q) => $q->where('status', 'present'),
                            'attendances as absent_count' => fn ($q) => $q->where('status', 'absent'),
                            'attendances as late_count' => fn ($q) => $q->where('status', 'late'),
                            'attendances as rank_1_count' => fn ($q) => $q->where('daily_rank', 1),
                            'attendances as rank_2_count' => fn ($q) => $q->where('daily_rank', 2),
                            'attendances as rank_3_count' => fn ($q) => $q->where('daily_rank', 3),
                        ]);
                    }, 
                    'classSchedule'
                ])
                ->when(request('attendance_date'), fn($q, $v) => $q->whereDate('attendance_date', $v))
                ->when($attendanceCourse || request('attendance_batch') || request('attendance_search'), function($q) use ($attendanceCourse) {
                    $q->whereHas('student', function($q2) use ($attendanceCourse) {
                        $q2->when($attendanceCourse, fn($q3, $v) => $q3->where('course', $v))
                           ->when(request('attendance_batch'), fn($q3, $v) => $q3->where('batch_id', $v))
                           ->when(request('attendance_search'), function($q3, $v) {
                               $q3->where(function($q4) use ($v) {
                                   $q4->where('name', 'like', "%{$v}%")
                                      ->orWhere('phone', 'like', "%{$v}%")
                                      ->orWhere('student_id', 'like', "%{$v}%");
                               });
                           });
                    });
                })
                ->latest('attendance_date')->paginate($perPage, ['*'], 'attendance_page')->withQueryString(),
                'classSchedules' => ComputerTrainingClassSchedule::orderBy('class_date')->orderBy('starts_at')->paginate($perPage, ['*'], 'class_page'),
                'courses' => \App\Models\ComputerTrainingCourse::where('status', 'active')->orderBy('name')->pluck('name'),
                'courseModels' => \App\Models\ComputerTrainingCourse::with('students')->withCount('students')->orderBy('name')->get(),
                'exams' => ComputerTrainingExam::orderBy('exam_date')->paginate($perPage, ['*'], 'exam_page'),
                'fees' => ComputerTrainingFee::with('student')
                    ->when(request('fee_status') === 'paid', fn ($q) => $q->whereColumn('paid_amount', '>=', 'amount')->orWhere('status', 'paid'))
                    ->when(request('fee_status') === 'due', fn ($q) => $q->whereColumn('paid_amount', '<', 'amount')->where('status', '!=', 'paid'))
                    ->latest('due_date')->paginate($perPage, ['*'], 'fee_page')->withQueryString(),
                'leads' => ComputerTrainingMarketingLead::when(request('marketing_status'), fn ($q, $v) => $q->where('status', $v))
                    ->when(request('marketing_source'), fn ($q, $v) => $q->where('source', $v))
                    ->when(request('marketing_search'), fn ($q, $v) => $q->where(fn($q2) => $q2->where('name', 'like', "%{$v}%")->orWhere('phone', 'like', "%{$v}%")))
                    ->latest()->paginate($perPage, ['*'], 'lead_page'),
                'marketingSources' => ComputerTrainingMarketingLead::whereNotNull('source')->where('source', '!=', '')->distinct()->pluck('source'),
                'notices' => ComputerTrainingNotice::latest('publish_date')->paginate($perPage, ['*'], 'notice_page'),
                'reminders' => Reminder::where('service_section', 'computer-training')->where('status', 'pending')->orderBy('remind_at')->paginate($perPage, ['*'], 'reminder_page'),
                'stats' => [
                    'active_students' => ComputerTrainingStudent::whereIn('status', ['admitted', 'active'])->count(),
                    'due_fees' => ComputerTrainingFee::whereIn('status', ['due', 'partial'])->sum('amount'),
                    'upcoming_classes' => ComputerTrainingClassSchedule::whereDate('class_date', '>=', today())->count(),
                    'open_leads' => ComputerTrainingMarketingLead::whereIn('status', ['new', 'contacted', 'interested'])->count(),
                ],
                'students' => ComputerTrainingStudent::with('batch')
                    ->when(request('student_search'), function ($q, $v) {
                        $q->where(function ($q2) use ($v) {
                            $q2->where('name', 'like', "%{$v}%")
                               ->orWhere('phone', 'like', "%{$v}%")
                               ->orWhere('student_id', 'like', "%{$v}%");
                        });
                    })
                    ->when(request('student_batch'), fn($q, $v) => $q->where('batch_id', $v))
                    ->when(request('student_status'), fn($q, $v) => $q->where('status', $v))
                    ->orderBy('student_id')->paginate($perPage, ['*'], 'student_page')->withQueryString(),
                'batches' => \App\Models\ComputerTrainingBatch::with(['students'])->withCount('students')->orderBy('type')->orderByRaw('LENGTH(name)')->orderBy('name')->get(),
            ]);
        }
        if ($service === 'bank-asia') {
            $stats = [
                'total_accounts' => \App\Models\BankAsiaAcCreation::count(),
                'pending_accounts' => \App\Models\BankAsiaAcCreation::where('status', 'pending')->count(),
                'total_tp_updates' => \App\Models\BankAsiaTpUpdate::count(),
                'active_certificates' => \App\Models\BankAsiaShonchoyPotro::where('status', 'active')->count(),
                'total_investment' => \App\Models\BankAsiaShonchoyPotro::where('status', 'active')->sum('purchase_amount'),
            ];
            
            $recentAcCreations = \App\Models\BankAsiaAcCreation::latest()->take(5)->get();
            $recentTpUpdates = \App\Models\BankAsiaTpUpdate::latest()->take(5)->get();
            $recentCertificates = \App\Models\BankAsiaShonchoyPotro::latest()->take(5)->get();
            
            return view('services.bank-asia.index', compact('stats', 'recentAcCreations', 'recentTpUpdates', 'recentCertificates'));
        }

        return view('services.show', [
            'service' => Reminder::SERVICES[$service],
        ]);
    }
}
