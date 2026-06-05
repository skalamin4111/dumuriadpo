<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $term = $request->string('q')->toString();

        return view('search.index', [
            'term' => $term,
            'tasks' => Task::where('title', 'like', "%{$term}%")->limit(10)->get(),
            'customers' => Customer::where('name', 'like', "%{$term}%")->orWhere('company_name', 'like', "%{$term}%")->limit(10)->get(),
            'employees' => Employee::with('user')->whereHas('user', fn ($query) => $query->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"))->limit(10)->get(),
        ]);
    }
}
