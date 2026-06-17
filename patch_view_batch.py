with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Update x-data
old_xdata = """<div x-data="{ batch: null }" class="surface overflow-hidden flex flex-col h-full">"""
new_xdata = """<div x-data="{ batch: null, viewBatch: null }" class="surface overflow-hidden flex flex-col h-full">"""
content = content.replace(old_xdata, new_xdata)

# 2. Update Table Row
old_tr = """<tr class="table-row">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $b->name }}</td>"""
new_tr = """<tr class="table-row cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50" @click="viewBatch = {{ Js::from($b) }}">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $b->name }}</td>"""
content = content.replace(old_tr, new_tr)

# 3. Add View button and click.stop to edit/delete
old_actions = """<div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="batch = {{ Js::from($b) }}" class="text-teal-600 hover:text-teal-800 transition">"""
new_actions = """<div class="flex items-center justify-end gap-2">
                                        <button type="button" @click.stop="viewBatch = {{ Js::from($b) }}" class="text-indigo-600 hover:text-indigo-800 transition" title="View Students"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                        <button type="button" @click.stop="batch = {{ Js::from($b) }}" class="text-teal-600 hover:text-teal-800 transition">"""
content = content.replace(old_actions, new_actions)

old_delete = """<button type="submit" class="text-rose-600 hover:text-rose-800 transition">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>"""
new_delete = """<button type="submit" @click.stop class="text-rose-600 hover:text-rose-800 transition">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>"""
content = content.replace(old_delete, new_delete)

# 4. Inject View Batch Modal
view_batch_modal = """
                <!-- View Batch Details Modal -->
                <template x-teleport="body">
                    <div x-show="viewBatch !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewBatch = null">
                            <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative p-6 md:p-8"
                                 x-transition:enter="transition ease-out duration-300" 
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                                 x-transition:leave="transition ease-in duration-200" 
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                                
                                <h2 class="mb-6 font-semibold text-xl flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                    <span>Batch Enrolled Students: <span x-text="viewBatch?.name" class="text-teal-600"></span> (<span x-text="viewBatch?.type"></span>)</span>
                                    <button type="button" @click="viewBatch = null" class="text-slate-400 hover:text-slate-600 transition">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </h2>

                                <div class="mb-4 flex items-center justify-between text-sm">
                                    <div class="flex gap-4">
                                        <div class="bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">
                                            <span class="text-slate-500">Status:</span> 
                                            <span class="font-medium text-slate-800 dark:text-slate-200" x-text="viewBatch?.status === 'active' ? 'Active' : 'Completed'"></span>
                                        </div>
                                        <div class="bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">
                                            <span class="text-slate-500">Enrolled:</span> 
                                            <span class="font-medium text-slate-800 dark:text-slate-200"><span x-text="viewBatch?.students?.length || 0"></span> / <span x-text="viewBatch?.capacity"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                                    <table class="w-full text-left text-sm whitespace-nowrap">
                                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                                            <tr>
                                                <th class="px-4 py-3 font-medium">Student Name</th>
                                                <th class="px-4 py-3 font-medium">Phone</th>
                                                <th class="px-4 py-3 font-medium">Course</th>
                                                <th class="px-4 py-3 font-medium">Admission Date</th>
                                                <th class="px-4 py-3 font-medium">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                            <template x-if="viewBatch?.students && viewBatch.students.length > 0">
                                                <template x-for="s in viewBatch.students" :key="s.id">
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                                        <td class="px-4 py-3">
                                                            <div class="font-medium text-slate-800 dark:text-slate-200" x-text="s.name"></div>
                                                            <div class="text-xs text-slate-500" x-text="s.student_id"></div>
                                                        </td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.phone || '-'"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.course"></td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.admission_date || '-'"></td>
                                                        <td class="px-4 py-3">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800" x-text="s.status.charAt(0).toUpperCase() + s.status.slice(1)"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>
                                            <template x-if="!viewBatch?.students || viewBatch.students.length === 0">
                                                <tr>
                                                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No students are enrolled in this batch yet.</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button type="button" @click="viewBatch = null" class="btn btn-secondary">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
"""

# Find place to inject modal (right before Batch List header)
batch_list_header = """<div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Batch List</h3>"""

if batch_list_header in content:
    content = content.replace(batch_list_header, view_batch_modal + "\n" + batch_list_header)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Batch view feature added!")
