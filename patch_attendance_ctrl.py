with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'r') as f:
    content = f.read()

attendance_methods = """    public function getBatchStudents(Request $request, ComputerTrainingBatch $batch)
    {
        if ($request->user() && $batch->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $students = $batch->students()->orderBy('seat_number')->get(['id', 'name', 'seat_number', 'phone', 'status']);
        
        return response()->json([
            'students' => $students
        ]);
    }

    public function storeBulkAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'batch_id' => ['required', 'exists:computer_training_batches,id'],
            'attendance_date' => ['required', 'date'],
            'attendances' => ['required', 'array'],
            'attendances.*.student_id' => ['required', 'exists:computer_training_students,id'],
            'attendances.*.status' => ['required', \Illuminate\Validation\Rule::in(['present', 'absent', 'late'])],
            'attendances.*.daily_rank' => ['nullable', 'integer', 'in:1,2,3'],
        ]);

        $companyId = $request->user() ? $request->user()->company_id : 1;

        foreach ($data['attendances'] as $att) {
            \App\Models\ComputerTrainingAttendance::updateOrCreate(
                [
                    'company_id' => $companyId,
                    'student_id' => $att['student_id'],
                    'attendance_date' => $data['attendance_date']
                ],
                [
                    'status' => $att['status'],
                    'daily_rank' => $att['daily_rank'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Bulk attendance recorded successfully.')->with('tab', 'attendance');
    }
}
"""

last_brace_index = content.rfind('}')
if last_brace_index != -1:
    content = content[:last_brace_index] + attendance_methods + content[last_brace_index+1:]

with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'w') as f:
    f.write(content)
print("Controller attendance methods added.")
