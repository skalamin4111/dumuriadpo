with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

view_modal_html = """
            <!-- View Student Details Modal -->
            <template x-teleport="body">
                <div x-show="viewStudent !== null" 
                     class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm" 
                     style="display:none"
                     x-transition.opacity>
                    <div class="flex min-h-full items-start justify-center p-4 sm:p-6 md:py-12" @click.self="viewStudent = null">
                        <div class="w-full max-w-3xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative p-6 md:p-8"
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-200" 
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                            
                            <h2 class="mb-6 font-semibold text-xl flex justify-between items-center pb-4 border-b border-slate-200 dark:border-slate-800">
                                <span>Student Details: <span x-text="viewStudent?.name" class="text-teal-600"></span></span>
                                <button type="button" @click="viewStudent = null" class="text-slate-400 hover:text-slate-600 transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-if="viewStudent">
                                
                                <div class="space-y-4">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Basic Info</h3>
                                    <div class="grid grid-cols-3 gap-2 text-sm">
                                        <div class="text-slate-500">Student ID:</div><div class="col-span-2 font-medium" x-text="viewStudent?.student_id || 'N/A'"></div>
                                        <div class="text-slate-500">Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.name"></div>
                                        <div class="text-slate-500">Name (BN):</div><div class="col-span-2 font-medium" x-text="viewStudent?.name_bn || 'N/A'"></div>
                                        <div class="text-slate-500">Father's Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.father_name || 'N/A'"></div>
                                        <div class="text-slate-500">Mother's Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.mother_name || 'N/A'"></div>
                                        <div class="text-slate-500">Date of Birth:</div><div class="col-span-2 font-medium" x-text="viewStudent?.date_of_birth || 'N/A'"></div>
                                        <div class="text-slate-500">Gender:</div><div class="col-span-2 font-medium" x-text="viewStudent?.gender || 'N/A'"></div>
                                        <div class="text-slate-500">Religion:</div><div class="col-span-2 font-medium" x-text="viewStudent?.religion || 'N/A'"></div>
                                        <div class="text-slate-500">Marital Status:</div><div class="col-span-2 font-medium" x-text="viewStudent?.marital_status || 'N/A'"></div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Contact & Course</h3>
                                    <div class="grid grid-cols-3 gap-2 text-sm">
                                        <div class="text-slate-500">Phone:</div><div class="col-span-2 font-medium" x-text="viewStudent?.phone || 'N/A'"></div>
                                        <div class="text-slate-500">Email:</div><div class="col-span-2 font-medium" x-text="viewStudent?.email || 'N/A'"></div>
                                        <div class="text-slate-500">Guardian Name:</div><div class="col-span-2 font-medium" x-text="viewStudent?.guardian_name || 'N/A'"></div>
                                        <div class="text-slate-500">Guardian Phone:</div><div class="col-span-2 font-medium" x-text="viewStudent?.guardian_phone || 'N/A'"></div>
                                        <div class="text-slate-500">Address:</div><div class="col-span-2 font-medium" x-text="viewStudent?.address || 'N/A'"></div>
                                        <div class="col-span-3 my-2 border-t border-slate-100 dark:border-slate-800"></div>
                                        <div class="text-slate-500">Course:</div><div class="col-span-2 font-medium" x-text="viewStudent?.course || 'N/A'"></div>
                                        <div class="text-slate-500">Batch:</div><div class="col-span-2 font-medium" x-text="viewStudent?.batch?.name || 'Unassigned'"></div>
                                        <div class="text-slate-500">Duration:</div><div class="col-span-2 font-medium" x-text="viewStudent?.duration || 'N/A'"></div>
                                        <div class="text-slate-500">Admission Date:</div><div class="col-span-2 font-medium" x-text="viewStudent?.admission_date || 'N/A'"></div>
                                        <div class="text-slate-500">Status:</div>
                                        <div class="col-span-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800" x-text="viewStudent?.status ? viewStudent.status.charAt(0).toUpperCase() + viewStudent.status.slice(1) : 'N/A'"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 md:col-span-2 space-y-4" x-show="viewStudent?.educational_qualifications && viewStudent.educational_qualifications.length > 0">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Educational Qualifications</h3>
                                    <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                                        <table class="w-full text-left text-sm whitespace-nowrap">
                                            <thead class="bg-slate-50 dark:bg-slate-800/50">
                                                <tr>
                                                    <th class="px-3 py-2 font-medium">Exam Name</th>
                                                    <th class="px-3 py-2 font-medium">Group</th>
                                                    <th class="px-3 py-2 font-medium">Institute</th>
                                                    <th class="px-3 py-2 font-medium">Passing Year</th>
                                                    <th class="px-3 py-2 font-medium">Board</th>
                                                    <th class="px-3 py-2 font-medium">Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                                <template x-for="(eq, index) in viewStudent?.educational_qualifications" :key="index">
                                                    <tr x-show="eq.exam_name">
                                                        <td class="px-3 py-2" x-text="eq.exam_name"></td>
                                                        <td class="px-3 py-2" x-text="eq.group"></td>
                                                        <td class="px-3 py-2" x-text="eq.institute"></td>
                                                        <td class="px-3 py-2" x-text="eq.passing_year"></td>
                                                        <td class="px-3 py-2" x-text="eq.board"></td>
                                                        <td class="px-3 py-2" x-text="eq.grade"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 md:col-span-2 space-y-2" x-show="viewStudent?.notes">
                                    <h3 class="font-medium text-lg text-slate-800 dark:text-slate-200 border-b pb-2">Notes</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg whitespace-pre-wrap" x-text="viewStudent?.notes"></p>
                                </div>

                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <button type="button" @click="viewStudent = null" class="btn btn-secondary">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
"""

# Inject before the end of the `students` section
table_start = """<div class="flex flex-col gap-4 sm:flex-row sm:items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Student List</h3>"""

if table_start in content:
    content = content.replace(table_start, view_modal_html + "\n" + table_start)
    with open('resources/views/services/computer-training.blade.php', 'w') as f:
        f.write(content)
    print("Modal injected successfully!")
else:
    print("Could not find table_start string.")

