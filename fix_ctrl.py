with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'r') as f:
    content = f.read()

crud_methods = """
    public function storeCourse(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        ComputerTrainingCourse::create($this->withCompany($request, $data));

        return back()->with('status', 'Course created successfully.')->with('tab', 'batches');
    }

    public function updateCourse(Request $request, ComputerTrainingCourse $course): RedirectResponse
    {
        if ($request->user() && $course->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $course->update($data);

        return back()->with('status', 'Course updated successfully.')->with('tab', 'batches');
    }

    public function destroyCourse(Request $request, ComputerTrainingCourse $course): RedirectResponse
    {
        if ($request->user() && $course->company_id !== $request->user()->company_id) {
            abort(403);
        }

        $course->delete();

        return back()->with('status', 'Course deleted successfully.')->with('tab', 'batches');
    }
}
"""

# Revert the bad replacement
content = content.replace(crud_methods, "}\n")

# Now properly append crud methods at the end of the class.
# The class ends with a `}`. Let's find the very last `}` and replace it.
last_brace_index = content.rfind('}')
if last_brace_index != -1:
    content = content[:last_brace_index] + crud_methods + content[last_brace_index+1:]

with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'w') as f:
    f.write(content)
print("Controller fixed!")
