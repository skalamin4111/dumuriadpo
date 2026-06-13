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

            return view('services.computer-training', [
                'attendanceRecords' => ComputerTrainingAttendance::with(['student', 'classSchedule'])->latest('attendance_date')->paginate($perPage, ['*'], 'attendance_page'),
                'classSchedules' => ComputerTrainingClassSchedule::orderBy('class_date')->orderBy('starts_at')->paginate($perPage, ['*'], 'class_page'),
                'courses' => ComputerTrainingController::COURSES,
                'exams' => ComputerTrainingExam::orderBy('exam_date')->paginate($perPage, ['*'], 'exam_page'),
                'fees' => ComputerTrainingFee::with('student')->latest('due_date')->paginate($perPage, ['*'], 'fee_page'),
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
                'students' => ComputerTrainingStudent::latest()->paginate($perPage, ['*'], 'student_page'),
            ]);
        }
        if ($service === 'bank-asia') {
            return redirect()->route('bank-asia.tp-updates.index');
        }

        return view('services.show', [
            'service' => Reminder::SERVICES[$service],
        ]);
    }
}
