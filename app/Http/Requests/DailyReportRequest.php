<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create reports');
    }

    public function rules(): array
    {
        return [
            'report_date' => ['required', 'date'],
            'completed_works' => ['required', 'string'],
            'time_spent_minutes' => ['required', 'integer', 'min:0'],
            'pending_work' => ['nullable', 'string'],
            'problems_faced' => ['nullable', 'string'],
        ];
    }
}
