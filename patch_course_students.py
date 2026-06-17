with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

# 1. Update x-data
search_xdata = """            <div x-show="activeSubTab === 'courses'" x-data="{ course: null }" class="surface overflow-hidden flex flex-col h-full">"""
replace_xdata = """            <div x-show="activeSubTab === 'courses'" x-data="{ course: null, viewCourse: null }" class="surface overflow-hidden flex flex-col h-full">"""
content = content.replace(search_xdata, replace_xdata)

# 2. Add viewCourse modal
# We'll insert it right after the existing course modal
search_course_modal_end = """                </template>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center"""

view_course_modal = """                </template>

                <!-- View Course Details Modal -->
                <template x-teleport="body">
                    <div x-show="viewCourse !== null" 
                         class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                         style="display:none"
                         x-transition.opacity>
                        <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewCourse = null">
                            <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative">
                                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 rounded-t-2xl">
                                    <div class="flex flex-col">
                                        <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200" x-text="viewCourse?.name"></h2>
                                        <span class="text-sm text-slate-500 font-medium mt-1">
                                            <span x-text="viewCourse?.students?.length || 0"></span> Enrolled Students
                                        </span>
                                    </div>
                                    <button type="button" @click="viewCourse = null" class="text-slate-400 hover:text-slate-600 transition bg-white dark:bg-slate-800 rounded-full p-2 shadow-sm border border-slate-200 dark:border-slate-700">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                                        <table class="w-full text-left text-sm whitespace-nowrap">
                                            <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                                <tr>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">ID</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Student Name</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Phone</th>
                                                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-400">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                <template x-if="!viewCourse?.students || viewCourse.students.length === 0">
                                                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No students enrolled in this course yet.</td></tr>
                                                </template>
                                                <template x-for="s in viewCourse?.students" :key="s.id">
                                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                                        <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300" x-text="s.id"></td>
                                                        <td class="px-4 py-3">
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs" x-text="s.name.charAt(0)"></div>
                                                                <span class="font-semibold text-slate-800 dark:text-slate-200" x-text="s.name"></span>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400" x-text="s.phone"></td>
                                                        <td class="px-4 py-3">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                                  :class="{
                                                                      'bg-yellow-100 text-yellow-800': s.status === 'lead',
                                                                      'bg-blue-100 text-blue-800': s.status === 'admitted',
                                                                      'bg-green-100 text-green-800': s.status === 'active',
                                                                      'bg-purple-100 text-purple-800': s.status === 'completed',
                                                                      'bg-slate-100 text-slate-800': s.status === 'dropped',
                                                                  }"
                                                                  x-text="s.status.charAt(0).toUpperCase() + s.status.slice(1)">
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center"""
content = content.replace(search_course_modal_end, view_course_modal)

# 3. Add column for "Enrolled" and row click handling in course list
# Header update
search_thead = """                            <th class="px-4 py-3">Course Name</th>
                            <th class="px-4 py-3">Duration</th>"""
replace_thead = """                            <th class="px-4 py-3">Course Name</th>
                            <th class="px-4 py-3">Enrolled</th>
                            <th class="px-4 py-3">Duration</th>"""
content = content.replace(search_thead, replace_thead)

# Body update
search_tr = """                            <tr class="table-row">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $c->name }}</td>
                                <td class="px-4 py-3">{{ $c->duration ?? '-' }}</td>"""
replace_tr = """                            <tr class="table-row cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" @click="viewCourse = {{ Js::from($c) }}">
                                <td class="px-4 py-3 font-medium text-teal-700 dark:text-teal-400">{{ $c->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-indigo-600 rounded-full">{{ $c->students_count }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $c->duration ?? '-' }}</td>"""
content = content.replace(search_tr, replace_tr)

# 4. Prevent default row click when clicking action buttons
search_actions = """                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="course = {{ Js::from($c) }}" class="text-teal-600 hover:text-teal-800 transition">"""
replace_actions = """                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click.stop="viewCourse = {{ Js::from($c) }}" class="text-indigo-600 hover:text-indigo-800 transition" title="View Students"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></button>
                                        <button type="button" @click.stop="course = {{ Js::from($c) }}" class="text-teal-600 hover:text-teal-800 transition">"""
content = content.replace(search_actions, replace_actions)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Course view details added")
