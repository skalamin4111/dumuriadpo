with open('app/Http/Controllers/Web/ServiceController.php', 'r') as f:
    content = f.read()

search = """'courses' => ComputerTrainingController::COURSES,"""
replace = """'courses' => \App\Models\ComputerTrainingCourse::where('status', 'active')->orderBy('name')->pluck('name'),
                'courseModels' => \App\Models\ComputerTrainingCourse::orderBy('name')->get(),"""

if search in content:
    content = content.replace(search, replace)
    with open('app/Http/Controllers/Web/ServiceController.php', 'w') as f:
        f.write(content)
    print("ServiceController updated")
else:
    print("ServiceController search string not found")
