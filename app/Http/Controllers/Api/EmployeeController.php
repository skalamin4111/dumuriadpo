<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
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

        return EmployeeResource::collection($this->employees->paginate($request->query()));
    }

    public function store(EmployeeRequest $request)
    {
        return new EmployeeResource($this->employees->create($request->validated()));
    }

    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        return new EmployeeResource($employee->load(['user', 'department']));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        return new EmployeeResource($this->employees->update($employee, $request->validated()));
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();
        return response()->noContent();
    }
}
