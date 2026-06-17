import re

with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Add Batches to tabs
old_tabs = """'students' => 'Students',"""
new_tabs = """'students' => 'Students',\n                    'batches' => 'Batches',"""
content = content.replace(old_tabs, new_tabs)

# 2. Add batch_id to the empty student object
old_empty_student = """email: '' }\""""
new_empty_student = """email: '', batch_id: '' }\""""
content = content.replace(old_empty_student, new_empty_student)

# 3. Add batch_id dropdown to Student form
# Finding the Course Name grid
course_grid_search = """<div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">প্রশিক্ষণ কোর্সের নাম / Course Name</label>"""
batch_html = """
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">ব্যাচ / Batch</label>
                                        <select class="field" name="batch_id" x-model="student.batch_id">
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $b)
                                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->type }}) - {{ $b->students_count }}/{{ $b->capacity }}</option>
                                            @endforeach
                                        </select>
                                    </div>"""

if course_grid_search in content:
    content = content.replace(course_grid_search, course_grid_search + batch_html)

# 4. Display batch in Student list table
table_row_old = """<td class="px-4 py-3 font-medium">{{ $student->name }}<span class="block text-xs text-slate-500">{{ $student->student_id }}</span></td>"""
table_row_new = """<td class="px-4 py-3 font-medium">
                                {{ $student->name }}
                                <span class="block text-xs text-slate-500">
                                    {{ $student->student_id }} 
                                    @if($student->batch) &bull; <span class="font-medium text-teal-600">{{ $student->batch->name }}</span> @endif
                                </span>
                            </td>"""
content = content.replace(table_row_old, table_row_new)

# 5. Add Batches Tab Content
batches_tab_html = """
        <section x-show="tab === 'batches'" class="grid gap-5">
            <div x-data="{ batch: null }" class="surface overflow-hidden flex flex-col h-full">
                
                <!-- Batch Modal -->
                <template x-teleport="body">
                    <div x-show="batch !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="batch = null">
                            <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <form method="POST" :action="batch && batch.id ? '{{ url('/services/computer-training/batches') }}/' + batch.id : '{{ route('computer-training.batches.store') }}'" class="p-6">
                                    @csrf
                                    <input type="hidden" name="_method" :value="batch && batch.id ? 'PUT' : 'POST'">
                                    
                                    <h2 class="mb-4 font-semibold text-lg flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                        <span x-text="batch && batch.id ? 'Edit Batch' : 'Add New Batch'"></span>
                                        <button type="button" @click="batch = null" class="text-slate-400 hover:text-slate-600 transition">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Batch Name</label>
                                            <input class="field" name="name" x-model="batch.name" placeholder="e.g. S-9, R-9" required>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                                            <select class="field" name="type" x-model="batch.type" required>
                                                <option value="S">S - Batch</option>
                                                <option value="R">R - Batch</option>
                                            </select>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Capacity</label>
                                            <input type="number" class="field" name="capacity" x-model="batch.capacity" required>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                            <select class="field" name="status" x-model="batch.status" required>
                                                <option value="active">Active</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary w-full py-3 mt-6 text-base font-semibold" x-text="batch && batch.id ? 'Update Batch' : 'Save Batch'"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Batch List</h3>
                    <button type="button" @click="batch = { id: null, name: '', type: 'S', capacity: 15, status: 'active' }" class="btn btn-primary shrink-0">Add New Batch</button>
                </div>

                <table class="w-full text-left text-sm">
                    <thead class="table-head">
                        <tr>
                            <th class="px-4 py-3">Batch Name</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Students</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse ($batches as $b)
                            <tr class="table-row">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $b->name }}</td>
                                <td class="px-4 py-3">{{ $b->type }} Batch</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                            <div class="bg-teal-600 h-2.5 rounded-full" style="width: {{ min(100, ($b->students_count / max(1, $b->capacity)) * 100) }}%"></div>
                                        </div>
                                        <span class="text-xs text-slate-500 font-medium">{{ $b->students_count }} / {{ $b->capacity }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $b->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="batch = {{ Js::from($b) }}" class="text-teal-600 hover:text-teal-800 transition">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form method="POST" action="{{ route('computer-training.batches.destroy', $b) }}" onsubmit="return confirm('Delete this batch?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 transition">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">No batches created yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
"""

# Inject before attendance section
content = content.replace("""<section x-show="tab === 'attendance'\"""", batches_tab_html + """\n        <section x-show="tab === 'attendance'\"""")

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Patched UI!")
