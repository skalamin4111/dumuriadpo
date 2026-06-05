<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Task;

class CalendarController extends Controller
{
    public function __invoke()
    {
        return view('calendar.index', [
            'tasks' => Task::with('assignee.user')->whereNotNull('deadline_at')->orderBy('deadline_at')->limit(60)->get(),
        ]);
    }
}
