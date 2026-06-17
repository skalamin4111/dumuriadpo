with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

import re

# Match the entire attendance section
match = re.search(r'(<section x-show="tab === \'attendance\'".*?</section>)', content, re.DOTALL)
if match:
    old_section = match.group(1)
    
    new_section = """        <section x-show="tab === 'attendance'" class="grid gap-5" x-data="{ 
            showBulkModal: false, 
            selectedCourse: '', 
            selectedBatchId: '', 
            attendanceDate: '{{ now()->toDateString() }}',
            students: [], 
            loading: false,
            
            fetchStudents() {
                if(!this.selectedBatchId) {
                    this.students = [];
                    return;
                }
                this.loading = true;
                fetch('{{ url('/services/computer-training/batches') }}/' + this.selectedBatchId + '/students')
                    .then(res => res.json())
                    .then(data => {
                        this.students = data.students.map(s => ({
                            student_id: s.id,
                            seat_number: s.seat_number,
                            name: s.name,
                            status: 'present', // default
                            daily_rank: '' // default empty
                        }));
                        this.loading = false;
                    });
            }
        }">
            
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Daily Attendance History</h2>
                <button type="button" @click="showBulkModal = true; selectedCourse = ''; selectedBatchId = ''; students = [];" class="btn btn-primary px-5 py-2.5">
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Check Attendance
                </button>
            </div>

            <!-- Bulk Attendance Modal -->
            <template x-teleport="body">
                <div x-show="showBulkModal" 
                     class="fixed inset-0 z-[100] overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-start justify-center p-4 sm:p-6 md:py-12" 
                     style="display:none"
                     x-transition.opacity>
                    
                    <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative flex flex-col max-h-[90vh]" @click.self="showBulkModal = false">
                        
                        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 rounded-t-2xl shrink-0">
                            <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200">Record Batch Attendance</h2>
                            <button type="button" @click="showBulkModal = false" class="text-slate-400 hover:text-slate-600 transition bg-white dark:bg-slate-800 rounded-full p-2 shadow-sm border border-slate-200 dark:border-slate-700">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('computer-training.attendance.bulk') }}" class="flex flex-col overflow-hidden h-full">
                            @csrf
                            
                            <div class="p-6 border-b border-slate-200 dark:border-slate-800 shrink-0 bg-white dark:bg-slate-900">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                </div>
                            </div>

                            <div class="overflow-y-auto p-6 flex-1 bg-slate-50/50 dark:bg-slate-900/50 relative">
                                <div x-show="loading" class="absolute inset-0 flex justify-center items-center bg-white/80 dark:bg-slate-900/80 z-10 backdrop-blur-sm">
                                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600"></div>
                                </div>

                                <div x-show="selectedBatchId && students.length === 0 && !loading" class="text-center py-12 text-slate-500 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    No students found in this batch.
                                </div>
                                
                                <div x-show="!selectedBatchId" class="text-center py-12 text-slate-500 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                    Please select a Batch to load the student list.
                                </div>

                                <div x-show="students.length > 0" class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">
                                    <table class="w-full text-left text-sm whitespace-nowrap">
                                        <thead class="bg-slate-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                                            <tr>
                                                <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300 w-20 text-center">Seat</th>
                                                <th class="px-4 py-3 font-semibold text-slate-700 dark:text-slate-300">Student Name</th>
                                                <th class="px-4 py-3 font-semibold text-green-700 dark:text-green-400 text-center w-24">Present</th>
                                                <th class="px-4 py-3 font-semibold text-red-700 dark:text-red-400 text-center w-24">Absent</th>
                                                <th class="px-4 py-3 font-semibold text-amber-700 dark:text-amber-500 w-40 text-center">Best Student</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                                            <template x-for="(s, index) in students" :key="s.student_id">
                                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition duration-150">
                                                    <input type="hidden" :name="`attendances[${index}][student_id]`" :value="s.student_id">
                                                    
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs" x-text="s.seat_number || '-'"></span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs shrink-0" x-text="s.name.charAt(0)"></div>
                                                            <span class="font-medium text-slate-800 dark:text-slate-200" x-text="s.name"></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer w-full h-full p-2">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="present" x-model="s.status" class="w-5 h-5 text-green-600 bg-slate-100 border-slate-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <label class="inline-flex items-center justify-center cursor-pointer w-full h-full p-2">
                                                            <input type="radio" :name="`attendances[${index}][status]`" value="absent" x-model="s.status" class="w-5 h-5 text-red-600 bg-slate-100 border-slate-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <select :name="`attendances[${index}][daily_rank]`" x-model="s.daily_rank" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                                                            <option value="">None</option>
                                                            <option value="1">1st Place 🏆</option>
                                                            <option value="2">2nd Place 🥈</option>
                                                            <option value="3">3rd Place 🥉</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="p-6 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 shrink-0 flex justify-end gap-3 rounded-b-2xl">
                                <button type="button" @click="showBulkModal = false" class="btn bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Cancel</button>
                                <button type="submit" class="btn btn-primary px-8" :disabled="students.length === 0 || loading">Save Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($attendanceRecords as $attendance)
                    <article class="surface p-5 hover:shadow-md transition-shadow relative overflow-hidden group">
                        @if($attendance->daily_rank)
                            <div class="absolute -right-6 top-4 bg-amber-500 text-white text-xs font-bold px-8 py-1 rotate-45 shadow-sm">
                                {{ $attendance->daily_rank }}{{ $attendance->daily_rank == 1 ? 'st' : ($attendance->daily_rank == 2 ? 'nd' : 'rd') }} Place
                            </div>
                        @endif
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold">
                                    {{ substr($attendance->student?->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 dark:text-slate-200 truncate max-w-[150px]">{{ $attendance->student?->name }}</h3>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $attendance->attendance_date->format('l, M j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800/50">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $attendance->status === 'present' ? 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400' : ($attendance->status === 'absent' ? 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </div>
                            @if($attendance->student?->batch)
                                <span class="text-xs text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">{{ $attendance->student->batch->name }}</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="col-span-full surface p-12 text-center text-slate-500 border border-dashed border-slate-300 dark:border-slate-700">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <p class="text-lg font-medium text-slate-700 dark:text-slate-300">No attendance records yet</p>
                        <p class="mt-1">Click "Check Attendance" above to record today's attendance.</p>
                    </div>
                @endforelse
            </div>
            @if($attendanceRecords->hasPages())
                <div class="mt-6 flex justify-end">{{ $attendanceRecords->appends(['tab' => 'attendance'])->links() }}</div>
            @endif
        </section>"""
        
    with open('resources/views/services/computer-training.blade.php', 'w') as f:
        f.write(content.replace(old_section, new_section))
    print("Attendance UI replaced successfully")
else:
    print("Failed to find attendance section")
