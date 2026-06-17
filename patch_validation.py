with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'r') as f:
    content = f.read()

# For storeStudent
store_search = """            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
        ]);"""
store_replace = """            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
            'seat_number' => ['nullable', 'integer', 'min:1', 'max:15', Rule::unique('computer_training_students')->where(function ($query) use ($request) {
                return $query->where('company_id', $request->user() ? $request->user()->company_id : 1)
                             ->where('batch_id', $request->batch_id);
            })],
        ]);"""
content = content.replace(store_search, store_replace)

# For updateStudent
update_search = """            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
        ]);

        $student->update($data);"""
update_replace = """            'batch_id' => ['nullable', 'exists:computer_training_batches,id'],
            'seat_number' => ['nullable', 'integer', 'min:1', 'max:15', Rule::unique('computer_training_students')->where(function ($query) use ($request, $student) {
                return $query->where('company_id', $student->company_id)
                             ->where('batch_id', $request->batch_id);
            })->ignore($student->id)],
        ]);

        $student->update($data);"""
content = content.replace(update_search, update_replace)

with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'w') as f:
    f.write(content)
print("Validation updated")
