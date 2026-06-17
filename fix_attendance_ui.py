with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Fix grid to flex row for Date, Course, Batch
search_grid = """                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Date</label>
                                        <input type="date" class="field" name="attendance_date" x-model="attendanceDate" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Course</label>
                                        <select class="field" x-model="selectedCourse">
                                            <option value="">Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course }}">{{ $course }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Batch</label>
                                        <select class="field" name="batch_id" x-model="selectedBatchId" @change="fetchStudents()" required>
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>"""

replace_flex = """                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Date</label>
                                        <input type="date" class="field" name="attendance_date" x-model="attendanceDate" required>
                                    </div>
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Course</label>
                                        <select class="field" x-model="selectedCourse">
                                            <option value="">Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course }}">{{ $course }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1 flex-1">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Batch</label>
                                        <select class="field" name="batch_id" x-model="selectedBatchId" @change="fetchStudents()" required>
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>"""
content = content.replace(search_grid, replace_flex)

# 2. Fix hover design issue on student rows.
# Currently it's `hover:bg-slate-50 dark:hover:bg-slate-800/50`. Let's change to `hover:bg-slate-100 dark:hover:bg-slate-800`
search_row = """                                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition duration-150">"""
replace_row = """                                                <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 transition duration-150">"""
content = content.replace(search_row, replace_row)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Attendance UI fixed")
