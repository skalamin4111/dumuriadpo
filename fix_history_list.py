with open('resources/views/services/computer-training.blade.php', 'r') as f:
    content = f.read()

search_history = """            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
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
                @empty"""

replace_history = """            <div class="flex flex-col gap-3">
                @forelse ($attendanceRecords as $attendance)
                    <article class="surface p-4 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        @if($attendance->daily_rank)
                            <div class="absolute -right-6 top-4 bg-amber-500 text-white text-[10px] font-bold px-8 py-0.5 rotate-45 shadow-sm sm:hidden">
                                {{ $attendance->daily_rank }}{{ $attendance->daily_rank == 1 ? 'st' : ($attendance->daily_rank == 2 ? 'nd' : 'rd') }}
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold text-lg shrink-0">
                                {{ substr($attendance->student?->name ?? '?', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-slate-800 dark:text-slate-200 truncate text-base">{{ $attendance->student?->name }}</h3>
                                    @if($attendance->daily_rank)
                                        <span class="hidden sm:inline-flex items-center gap-1 text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 px-2 py-0.5 rounded-full">
                                            🏆 {{ $attendance->daily_rank }}{{ $attendance->daily_rank == 1 ? 'st' : ($attendance->daily_rank == 2 ? 'nd' : 'rd') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 mt-1 text-sm text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $attendance->attendance_date->format('l, M j, Y') }}
                                    </div>
                                    @if($attendance->student?->batch)
                                        <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-xs font-medium">{{ $attendance->student->batch->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800/50">
                            
                            <div class="flex items-center gap-4 text-xs font-medium">
                                <div class="flex flex-col items-center">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-wider mb-0.5">Present</span>
                                    <span class="text-green-600 dark:text-green-400">{{ $attendance->student?->present_count ?? 0 }}</span>
                                </div>
                                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700"></div>
                                <div class="flex flex-col items-center">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-wider mb-0.5">Absent</span>
                                    <span class="text-red-600 dark:text-red-400">{{ $attendance->student?->absent_count ?? 0 }}</span>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $attendance->status === 'present' ? 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400' : ($attendance->status === 'absent' ? 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400') }}">
                                {{ $attendance->status }}
                            </span>
                        </div>
                    </article>
                @empty"""
content = content.replace(search_history, replace_history)

with open('resources/views/services/computer-training.blade.php', 'w') as f:
    f.write(content)
print("Attendance history list updated")
