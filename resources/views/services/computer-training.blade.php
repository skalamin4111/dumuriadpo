<x-app-layout title="Computer Training">
    <div x-data="{ tab: '{{ session('tab', old('tab', request('tab', 'students'))) }}', marketingLead: null }" class="space-y-5">
        <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Active students</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['active_students'] }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Upcoming classes</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['upcoming_classes'] }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Open leads</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['open_leads'] }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Fee receivable</p>
                <p class="mt-2 text-2xl font-semibold">{{ number_format($stats['due_fees'], 2) }}</p>
            </div>
        </section>

        @if ($errors->any())
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-900 dark:bg-rose-950 dark:text-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="surface p-2">
            <div class="flex gap-1 overflow-x-auto">
                @foreach ([
                    'students' => 'Students',
                    'attendance' => 'Attendance',
                    'classes' => 'Class Schedule',
                    'exams' => 'Class Exam',
                    'fees' => 'Fee Management',
                    'marketing' => 'Marketing',
                    'reminders' => 'To-do / Reminder',
                    'notices' => 'Notice',
                ] as $key => $label)
                    <button type="button" x-on:click="tab = '{{ $key }}'" class="shrink-0 rounded-md px-3 py-2 text-sm font-medium transition" x-bind:class="tab === '{{ $key }}' ? 'bg-teal-600 text-white' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'">{{ $label }}</button>
                @endforeach
            </div>
        </section>

        <section x-show="tab === 'students'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.students.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Student database</h2>
                <div class="space-y-3">
                    <input class="field" name="student_id" value="{{ old('student_id') }}" placeholder="Student ID">
                    <input class="field" name="name" value="{{ old('name') }}" placeholder="Student name" required>
                    <input class="field" name="phone" value="{{ old('phone') }}" placeholder="Phone">
                    <input class="field" name="guardian_phone" value="{{ old('guardian_phone') }}" placeholder="Guardian phone">
                    <input class="field" name="email" value="{{ old('email') }}" type="email" placeholder="Email">
                    <select class="field" name="course" required>
                        <option value="">Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course }}" @selected(old('course') === $course)>{{ $course }}</option>
                        @endforeach
                    </select>
                    <input class="field" name="admission_date" type="date" value="{{ old('admission_date', now()->toDateString()) }}">
                    <select class="field" name="status">
                        @foreach (['lead', 'admitted', 'active', 'completed', 'dropped'] as $status)
                            <option value="{{ $status }}" @selected(old('status', 'admitted') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <textarea class="field" name="address" placeholder="Address">{{ old('address') }}</textarea>
                    <textarea class="field" name="notes" placeholder="Notes">{{ old('notes') }}</textarea>
                    <button class="btn btn-primary w-full">Save student</button>
                </div>
            </form>

            <div class="surface overflow-hidden flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-800 dark:text-slate-200">Student List</h3>
                    <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                        <input type="hidden" name="tab" value="students">
                        <select name="per_page" onchange="this.form.submit()" class="field text-sm py-1.5 pl-3 pr-8 w-auto">
                            <option value="10" @selected(request('per_page') == 10)>10 per page</option>
                            <option value="25" @selected(request('per_page') == 25)>25 per page</option>
                            <option value="50" @selected(request('per_page') == 50)>50 per page</option>
                            <option value="100" @selected(request('per_page') == 100)>100 per page</option>
                        </select>
                    </form>
                </div>
                <table class="w-full text-left text-sm">
                    <thead class="table-head"><tr><th class="px-4 py-3">Student</th><th class="px-4 py-3">Course</th><th class="px-4 py-3">Phone</th><th class="px-4 py-3">Status</th></tr></thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse ($students as $student)
                            <tr class="table-row"><td class="px-4 py-3 font-medium">{{ $student->name }}<span class="block text-xs text-slate-500">{{ $student->student_id }}</span></td><td class="px-4 py-3">{{ $student->course }}</td><td class="px-4 py-3">{{ $student->phone ?? 'N/A' }}</td><td class="px-4 py-3">{{ ucfirst($student->status) }}</td></tr>
                        @empty
                            <tr><td class="px-4 py-5 text-center text-slate-500" colspan="4">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $students->appends(['tab' => 'students'])->links() }}</div>
        </section>

        <section x-show="tab === 'attendance'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.attendance.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Attendance</h2>
                <div class="space-y-3">
                    <select class="field" name="student_id" required><option value="">Student</option>@foreach ($students as $student)<option value="{{ $student->id }}">{{ $student->name }}</option>@endforeach</select>
                    <select class="field" name="class_schedule_id"><option value="">Class</option>@foreach ($classSchedules as $class)<option value="{{ $class->id }}">{{ $class->batch_name }} - {{ $class->class_date->format('M j') }}</option>@endforeach</select>
                    <input class="field" name="attendance_date" type="date" value="{{ now()->toDateString() }}" required>
                    <select class="field" name="status"><option value="present">Present</option><option value="absent">Absent</option><option value="late">Late</option></select>
                    <textarea class="field" name="remarks" placeholder="Remarks"></textarea>
                    <button class="btn btn-primary w-full">Record attendance</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($attendanceRecords as $attendance)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $attendance->student?->name }}</h3><p class="text-sm text-slate-500">{{ $attendance->classSchedule?->batch_name ?? 'General class' }}</p></div><div class="text-right"><p class="font-medium">{{ ucfirst($attendance->status) }}</p><p class="text-sm text-slate-500">{{ $attendance->attendance_date->format('M j, Y') }}</p></div></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No attendance records.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $attendanceRecords->appends(['tab' => 'attendance'])->links() }}</div>
        </section>

        <section x-show="tab === 'classes'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.classes.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Class schedule</h2>
                <div class="space-y-3">
                    <select class="field" name="course" required><option value="">Course</option>@foreach ($courses as $course)<option value="{{ $course }}">{{ $course }}</option>@endforeach</select>
                    <input class="field" name="batch_name" placeholder="Batch name" required>
                    <input class="field" name="instructor" placeholder="Instructor">
                    <input class="field" name="room" placeholder="Room">
                    <input class="field" name="class_date" type="date" value="{{ now()->toDateString() }}" required>
                    <div class="grid grid-cols-2 gap-3"><input class="field" name="starts_at" type="time" required><input class="field" name="ends_at" type="time" required></div>
                    <textarea class="field" name="topic" placeholder="Topic"></textarea>
                    <button class="btn btn-primary w-full">Save class</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($classSchedules as $class)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $class->batch_name }}</h3><p class="text-sm text-slate-500">{{ $class->course }} · {{ $class->topic }}</p></div><div class="text-right"><p class="font-medium">{{ $class->class_date->format('M j, Y') }}</p><p class="text-sm text-slate-500">{{ $class->starts_at }} - {{ $class->ends_at }}</p></div></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No classes scheduled.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $classSchedules->appends(['tab' => 'classes'])->links() }}</div>
        </section>

        <section x-show="tab === 'exams'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.exams.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Class exam</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Exam title" required>
                    <select class="field" name="course" required><option value="">Course</option>@foreach ($courses as $course)<option value="{{ $course }}">{{ $course }}</option>@endforeach</select>
                    <select class="field" name="class_schedule_id"><option value="">Related class</option>@foreach ($classSchedules as $class)<option value="{{ $class->id }}">{{ $class->batch_name }} - {{ $class->class_date->format('M j') }}</option>@endforeach</select>
                    <input class="field" name="exam_date" type="date" required>
                    <input class="field" name="starts_at" type="time">
                    <input class="field" name="total_marks" type="number" value="100" min="1" required>
                    <textarea class="field" name="syllabus" placeholder="Syllabus"></textarea>
                    <button class="btn btn-primary w-full">Schedule exam</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($exams as $exam)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $exam->title }}</h3><p class="text-sm text-slate-500">{{ $exam->course }} · {{ $exam->total_marks }} marks</p></div><p class="font-medium">{{ $exam->exam_date->format('M j, Y') }}</p></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No exams scheduled.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $exams->appends(['tab' => 'exams'])->links() }}</div>
        </section>

        <section x-show="tab === 'fees'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.fees.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Fee management</h2>
                <div class="space-y-3">
                    <select class="field" name="student_id" required><option value="">Student</option>@foreach ($students as $student)<option value="{{ $student->id }}">{{ $student->name }}</option>@endforeach</select>
                    <input class="field" name="amount" type="number" step="0.01" min="0" placeholder="Total amount" required>
                    <input class="field" name="paid_amount" type="number" step="0.01" min="0" placeholder="Paid amount">
                    <input class="field" name="due_date" type="date" required>
                    <input class="field" name="paid_at" type="date">
                    <select class="field" name="status"><option value="due">Due</option><option value="partial">Partial</option><option value="paid">Paid</option><option value="waived">Waived</option></select>
                    <input class="field" name="payment_method" placeholder="Payment method">
                    <textarea class="field" name="remarks" placeholder="Remarks"></textarea>
                    <button class="btn btn-primary w-full">Save fee</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($fees as $fee)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $fee->student?->name }}</h3><p class="text-sm text-slate-500">{{ ucfirst($fee->status) }} · Due {{ $fee->due_date->format('M j') }}</p></div><div class="text-right"><p class="font-semibold">{{ number_format($fee->paid_amount, 2) }}</p><p class="text-sm text-slate-500">of {{ number_format($fee->amount, 2) }}</p></div></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No fee records.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $fees->appends(['tab' => 'fees'])->links() }}</div>
        </section>

        <section x-show="tab === 'marketing'" class="grid gap-5">
            <!-- Modal Container -->
            <template x-teleport="body">
                <div x-show="marketingLead !== null" 
                     class="fixed inset-0 z-[100] grid place-items-center bg-slate-950/60 backdrop-blur-sm p-4" 
                     style="display:none"
                     x-transition.opacity>
                    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden relative" 
                         @click.away="marketingLead = null" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" 
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-200" 
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0">
                    <form method="POST" :action="marketingLead && marketingLead.id ? '{{ url('/services/computer-training/marketing') }}/' + marketingLead.id : '{{ route('computer-training.marketing.store') }}'" class="p-5">
                        @csrf
                        <input type="hidden" name="_method" :value="marketingLead && marketingLead.id ? 'PUT' : 'POST'">
                        <h2 class="mb-4 font-semibold text-lg flex justify-between items-center">
                            <span x-text="marketingLead && marketingLead.id ? 'Edit Student' : 'Add New Student'"></span>
                            <button type="button" @click="marketingLead = null" class="text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </h2>
                        <div class="space-y-3">
                            <input class="field" name="name" x-model="marketingLead.name" placeholder="Student name" required>
                            <input class="field" name="phone" x-model="marketingLead.phone" placeholder="Phone">
                            <select class="field" name="interested_course" x-model="marketingLead.interested_course">
                                <option value="">Interested course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course }}">{{ $course }}</option>
                                @endforeach
                            </select>
                            <select class="field" name="duration" x-model="marketingLead.duration">
                                <option value="">Duration</option>
                                <option value="1 month">1 month</option>
                                <option value="2 months">2 months</option>
                                <option value="3 months">3 months</option>
                                <option value="4 months">4 months</option>
                                <option value="5 months">5 months</option>
                                <option value="6 months">6 months</option>
                            </select>
                            <input class="field" name="source" x-model="marketingLead.source" placeholder="Source">
                            <select class="field" name="status" x-model="marketingLead.status">
                                <option value="new">New</option>
                                <option value="contacting">Contacting</option>
                                <option value="interested">Interested</option>
                                <option value="admitted">Admitted</option>
                                <option value="not interested">Not Interested</option>
                            </select>
                            
                            <template x-if="marketingLead.status === 'contacting'">
                                <select class="field" name="call_status" x-model="marketingLead.call_status">
                                    <option value="">Select call status</option>
                                    <option value="phone not received">Phone not received</option>
                                    <option value="call rejected">Call rejected</option>
                                    <option value="number busy">Number busy</option>
                                    <option value="wrong number">Wrong number</option>
                                </select>
                            </template>
                            
                            <template x-if="marketingLead.status === 'interested'">
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">When will come</label>
                                    <input class="field" name="next_follow_up_at" type="datetime-local" :value="marketingLead && marketingLead.next_follow_up_at ? marketingLead.next_follow_up_at.replace(' ', 'T').slice(0,16) : ''" @change="marketingLead.next_follow_up_at = $event.target.value">
                                </div>
                            </template>
                            
                            <textarea class="field" name="notes" x-model="marketingLead.notes" placeholder="Imported Info / Old Notes"></textarea>
                            <textarea class="field" name="remarks" x-model="marketingLead.remarks" placeholder="Marketing Note"></textarea>
                            <button class="btn btn-primary w-full" x-text="marketingLead && marketingLead.id ? 'Update student' : 'Save student'"></button>
                        </div>
                    </form>
                </div>
            </div>
            </template>
            
            <div class="grid gap-3">
                <div class="surface rounded-xl overflow-hidden shadow-sm shadow-slate-200/50 dark:shadow-none focus-within:ring-2 focus-within:ring-teal-500/50 transition-all">
                    <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row items-center w-full bg-white dark:bg-slate-950">
                        <input type="hidden" name="tab" value="marketing">
                        @if(request()->has('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                        
                        <div class="relative flex-1 w-full sm:border-r border-slate-200 dark:border-slate-800 flex items-center">
                            <svg class="w-5 h-5 absolute left-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="marketing_search" value="{{ request('marketing_search') }}" placeholder="Search by name or mobile..." class="w-full bg-transparent border-0 focus:ring-0 pl-12 py-3.5 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 outline-none">
                            @if(request('marketing_search'))
                                <a href="{{ url()->current() }}?tab=marketing&marketing_status={{ request('marketing_status') }}&marketing_source={{ request('marketing_source') }}&per_page={{ request('per_page') }}" class="absolute right-3 p-1 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 dark:hover:text-slate-300 transition">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </div>
                        
                        <div class="flex items-center w-full sm:w-auto pl-3 pr-2 py-2 sm:py-0 border-t sm:border-t-0 border-slate-200 dark:border-slate-800">
                            <select name="marketing_status" class="bg-transparent border-0 text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-0 outline-none cursor-pointer hover:text-slate-900 dark:hover:text-white transition w-full sm:w-auto [&>option]:dark:bg-slate-900" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="new" @selected(request('marketing_status') === 'new')>New</option>
                                <option value="contacting" @selected(request('marketing_status') === 'contacting')>Contacting</option>
                                <option value="interested" @selected(request('marketing_status') === 'interested')>Interested</option>
                                <option value="admitted" @selected(request('marketing_status') === 'admitted')>Admitted</option>
                                <option value="not interested" @selected(request('marketing_status') === 'not interested')>Not Interested</option>
                            </select>
                            
                            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block mx-1"></div>
                            
                            <select name="marketing_source" class="bg-transparent border-0 text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-0 outline-none cursor-pointer hover:text-slate-900 dark:hover:text-white transition w-full sm:w-auto mt-2 sm:mt-0 [&>option]:dark:bg-slate-900" onchange="this.form.submit()">
                                <option value="">All Schools</option>
                                @foreach($marketingSources ?? [] as $source)
                                    <option value="{{ $source }}" @selected(request('marketing_source') === $source)>{{ $source }}</option>
                                @endforeach
                            </select>
                            
                            <button type="submit" class="hidden sm:inline-flex ml-2 items-center justify-center rounded-lg bg-teal-600 p-2 text-white hover:bg-teal-700 transition shadow-sm shadow-teal-900/10">
                                <svg class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="flex flex-col gap-4 surface p-4 sm:flex-row sm:items-center sm:justify-between">
                    <button type="button" @click="marketingLead = { id: null, name: '', phone: '', interested_course: '', duration: '', source: '', status: 'new', call_status: '', next_follow_up_at: '', notes: '', remarks: '' }" class="btn btn-primary shrink-0">Add New Student</button>
                    <form method="POST" action="{{ route('computer-training.marketing.import') }}" enctype="multipart/form-data" class="flex flex-1 items-center justify-end gap-2">
                        @csrf
                        <input type="hidden" name="tab" value="marketing">
                        <input type="file" name="file" accept=".xlsx,.csv,.xls" class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-md file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-teal-700 hover:file:bg-teal-100 dark:file:bg-teal-900/50 dark:file:text-teal-400 dark:text-slate-400" required>
                        <button type="submit" class="btn btn-primary shrink-0">Import</button>
                    </form>
                    <div class="flex items-center gap-2 shrink-0">
                        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                            <input type="hidden" name="tab" value="marketing">
                            @if(request()->has('marketing_search'))
                                <input type="hidden" name="marketing_search" value="{{ request('marketing_search') }}">
                            @endif
                            @if(request()->has('marketing_status'))
                                <input type="hidden" name="marketing_status" value="{{ request('marketing_status') }}">
                            @endif
                            <select name="per_page" onchange="this.form.submit()" class="field text-sm py-1.5 pl-3 pr-8 w-auto border border-slate-300 dark:border-slate-700">
                                <option value="10" @selected(request('per_page') == 10)>10</option>
                                <option value="25" @selected(request('per_page') == 25)>25</option>
                                <option value="50" @selected(request('per_page') == 50)>50</option>
                                <option value="100" @selected(request('per_page') == 100)>100</option>
                            </select>
                        </form>
                        <a href="{{ route('computer-training.marketing.export') }}" class="btn rounded-md border border-slate-300 px-4 py-1.5 text-sm font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Export</a>
                    </div>
                </div>
                @forelse ($leads as $lead)
                    <article @click="marketingLead = {{ Js::from($lead) }}" class="surface p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        <div class="flex justify-between gap-3">
                            <div>
                                <h3 class="font-semibold">{{ $lead->name }}</h3>
                                <p class="text-sm text-slate-500">{{ $lead->phone ?? 'No phone' }} · {{ $lead->interested_course ?? 'No course' }}@if($lead->duration) · {{ $lead->duration }}@endif</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">{{ ucfirst($lead->status) }}</p>
                                <p class="text-sm text-slate-500">{{ $lead->source ?? 'Direct' }}</p>
                                @if($lead->status === 'contacting' && $lead->call_status)
                                    <p class="text-xs text-rose-500 font-medium mt-1">{{ ucfirst($lead->call_status) }}</p>
                                @elseif($lead->status === 'interested' && $lead->next_follow_up_at)
                                    <p class="text-xs text-emerald-600 font-medium mt-1">Visit: {{ $lead->next_follow_up_at->format('M j, Y g:i A') }}</p>
                                @endif
                            </div>
                        </div>
                        @if($lead->notes || $lead->remarks)
                            <div class="mt-3 border-t border-slate-100 pt-3 dark:border-slate-800 text-sm text-slate-600 dark:text-slate-400 whitespace-pre-wrap">@if($lead->notes){{ $lead->notes }}@endif
@if($lead->remarks)

<span class="font-medium text-slate-800 dark:text-slate-200">Note:</span> {{ $lead->remarks }}@endif</div>
                        @endif
                    </article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No marketing leads.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $leads->appends(['tab' => 'marketing', 'marketing_search' => request('marketing_search'), 'marketing_status' => request('marketing_status'), 'marketing_source' => request('marketing_source')])->links() }}</div>
        </section>

        <section x-show="tab === 'reminders'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.reminders.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">To-do / reminder</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Title" required>
                    <textarea class="field" name="purpose" placeholder="Task or reminder purpose" required></textarea>
                    <textarea class="field" name="follow_up_notes" placeholder="Follow-up notes"></textarea>
                    <input class="field" name="remind_at" type="datetime-local" required>
                    <button class="btn btn-primary w-full">Save reminder</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($reminders as $reminder)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $reminder->title }}</h3><p class="text-sm text-slate-500">{{ $reminder->purpose }}</p></div><div class="text-right"><p class="font-medium">{{ $reminder->remind_at->format('M j, Y') }}</p><p class="text-sm text-slate-500">{{ $reminder->remind_at->diffForHumans() }}</p></div></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No pending reminders.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $reminders->appends(['tab' => 'reminders'])->links() }}</div>
        </section>

        <section x-show="tab === 'notices'" class="grid gap-5 xl:grid-cols-[24rem_1fr]">
            <form method="POST" action="{{ route('computer-training.notices.store') }}" class="surface p-5">
                @csrf
                <h2 class="mb-4 font-semibold">Notice</h2>
                <div class="space-y-3">
                    <input class="field" name="title" placeholder="Notice title" required>
                    <textarea class="field" name="body" placeholder="Notice body" required></textarea>
                    <input class="field" name="publish_date" type="date" value="{{ now()->toDateString() }}" required>
                    <select class="field" name="audience"><option value="all">All</option><option value="students">Students</option><option value="leads">Leads</option><option value="staff">Staff</option></select>
                    <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300"><input class="rounded border-slate-300 text-teal-600 focus:ring-teal-500" type="checkbox" name="is_active" value="1" checked> Active</label>
                    <button class="btn btn-primary w-full">Publish notice</button>
                </div>
            </form>
            <div class="grid gap-3">
                @forelse ($notices as $notice)
                    <article class="surface p-4"><div class="flex justify-between gap-3"><div><h3 class="font-semibold">{{ $notice->title }}</h3><p class="mt-1 text-sm text-slate-500">{{ $notice->body }}</p></div><div class="text-right"><p class="font-medium">{{ ucfirst($notice->audience) }}</p><p class="text-sm text-slate-500">{{ $notice->publish_date->format('M j, Y') }}</p></div></div></article>
                @empty
                    <div class="surface p-5 text-center text-sm text-slate-500">No notices.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $notices->appends(['tab' => 'notices'])->links() }}</div>
        </section>
    </div>
</x-app-layout>
