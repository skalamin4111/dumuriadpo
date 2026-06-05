<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyReportRequest;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', DailyReport::class);
        return view('reports.index', ['reports' => DailyReport::with('employee.user')->latest()->paginate(15)]);
    }

    public function store(DailyReportRequest $request)
    {
        DailyReport::updateOrCreate(
            ['employee_id' => $request->user()->employee->id, 'report_date' => $request->date('report_date')],
            $request->validated()
        );

        return back()->with('status', 'Daily report submitted.');
    }
}
