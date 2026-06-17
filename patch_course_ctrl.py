with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'r') as f:
    content = f.read()

# 1. Add namespace for Course
import_stmt = "use App\Models\ComputerTrainingCourse;"
if import_stmt not in content:
    content = content.replace("use App\Models\ComputerTrainingBatch;", "use App\Models\ComputerTrainingBatch;\nuse App\Models\ComputerTrainingCourse;")

# 2. Remove COURSES array
const_courses = """    public const COURSES = [
        'Basic Computer',
        'Office Application',
        'Graphic Design',
        'Web Development',
        'Freelancing',
        'Digital Marketing',
        'Diploma in software application',
    ];"""
content = content.replace(const_courses, "")

# 3. Add course CRUD methods at the end
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
content = content.replace("}\n", crud_methods)

with open('app/Http/Controllers/Web/ComputerTrainingController.php', 'w') as f:
    f.write(content)
print("ComputerTrainingController updated")
