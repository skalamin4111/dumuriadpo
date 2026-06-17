with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Rename tab in the top navigation
search_tab_btn = """<button type="button" @click="tab = 'batches'" :class="tab === 'batches' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-3 py-2 rounded-lg text-sm transition whitespace-nowrap">Batches</button>"""
replace_tab_btn = """<button type="button" @click="tab = 'batches'" :class="tab === 'batches' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-3 py-2 rounded-lg text-sm transition whitespace-nowrap">Course / Batches</button>"""
content = content.replace(search_tab_btn, replace_tab_btn)

# 2. Restructure Batches section
search_section = """        <section x-show="tab === 'batches'" class="grid gap-5">
            <div x-data="{ batch: null, viewBatch: null }" class="surface overflow-hidden flex flex-col h-full">"""
replace_section = """        <section x-show="tab === 'batches'" class="grid gap-5" x-data="{ activeSubTab: 'batches' }">
            
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <button type="button" @click="activeSubTab = 'batches'" :class="activeSubTab === 'batches' ? 'bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-4 py-2 rounded-lg text-sm transition whitespace-nowrap">Batch Management</button>
                <button type="button" @click="activeSubTab = 'courses'" :class="activeSubTab === 'courses' ? 'bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-slate-200'" class="px-4 py-2 rounded-lg text-sm transition whitespace-nowrap">Course Management</button>
            </div>

            <!-- Batch Management -->
            <div x-show="activeSubTab === 'batches'" x-data="{ batch: null, viewBatch: null }" class="surface overflow-hidden flex flex-col h-full">"""
content = content.replace(search_section, replace_section)

# 3. Add Course Management UI at the end of the Batches section
# We need to find the end of the batches section. It ends with `</section>`
# Wait, there's only one `</section>` after the batches section starts. Actually there are multiple sections for tabs.
# The `tab === 'batches'` section ends right before `        <section x-show="tab === 'notices'" ...`
# Or I can just replace `            </div>\n        </section>\n\n        \n        <section x-show="tab === 'notices'"`
search_section_end = """            </div>
        </section>

        
        <section x-show="tab === 'notices'"""

course_ui = """            </div>

            <!-- Course Management -->
            <div x-show="activeSubTab === 'courses'" x-data="{ course: null }" class="surface overflow-hidden flex flex-col h-full">
                
                <!-- Course Modal -->
                <template x-teleport="body">
                    <div x-show="course !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="course = null">
                            <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <form method="POST" :action="course && course.id ? '{{ url('/services/computer-training/courses') }}/' + course.id : '{{ route('computer-training.courses.store') }}'" class="p-6">
                                    @csrf
                                    <input type="hidden" name="_method" :value="course && course.id ? 'PUT' : 'POST'">
                                    
                                    <h2 class="mb-4 font-semibold text-lg flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                        <span x-text="course && course.id ? 'Edit Course' : 'Add New Course'"></span>
                                        <button type="button" @click="course = null" class="text-slate-400 hover:text-slate-600 transition">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Course Name</label>
                                            <input class="field" name="name" x-model="course.name" placeholder="e.g. Graphic Design" required>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Duration (Optional)</label>
                                            <input class="field" name="duration" x-model="course.duration" placeholder="e.g. 6 Months">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Fee (Optional)</label>
                                            <input type="number" step="0.01" class="field" name="fee" x-model="course.fee" placeholder="0.00">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                            <select class="field" name="status" x-model="course.status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary w-full py-3 mt-6 text-base font-semibold" x-text="course && course.id ? 'Update Course' : 'Save Course'"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Course List</h3>
                    <button type="button" @click="course = { id: null, name: '', duration: '', fee: '', status: 'active' }" class="btn btn-primary shrink-0">Add New Course</button>
                </div>

                <table class="w-full text-left text-sm">
                    <thead class="table-head">
                        <tr>
                            <th class="px-4 py-3">Course Name</th>
                            <th class="px-4 py-3">Duration</th>
                            <th class="px-4 py-3">Fee</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse ($courseModels as $c)
                            <tr class="table-row">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $c->name }}</td>
                                <td class="px-4 py-3">{{ $c->duration ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $c->fee ? number_format($c->fee, 2) : '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $c->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                        {{ ucfirst($c->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="course = {{ Js::from($c) }}" class="text-teal-600 hover:text-teal-800 transition">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form method="POST" action="{{ route('computer-training.courses.destroy', $c) }}" onsubmit="return confirm('Delete this course?')">
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
                            <tr><td class="px-4 py-5 text-center text-slate-500" colspan="5">No courses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        
        <section x-show="tab === 'notices'"""
content = content.replace(search_section_end, course_ui)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("UI tabs updated")
