<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeService $employees)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Employee::class);

        return view('employees.index', [
            'employees' => $this->employees->paginate($request->query()),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo_path'] = $request->file('profile_photo')->store('employees', 'public');
        }
        $this->employees->create($data);
        return back()->with('status', 'Employee created.');
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $this->employees->update($employee, $request->validated());
        return back()->with('status', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();
        return back()->with('status', 'Employee archived.');
    }
}
