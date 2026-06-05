<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyReportRequest;
use App\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', DailyReport::class);
        return DailyReport::with('employee.user')->latest()->paginate();
    }

    public function store(DailyReportRequest $request)
    {
        $employee = $request->user()->employee;

        return DailyReport::updateOrCreate(
            ['employee_id' => $employee->id, 'report_date' => $request->date('report_date')],
            $request->validated()
        );
    }
}
