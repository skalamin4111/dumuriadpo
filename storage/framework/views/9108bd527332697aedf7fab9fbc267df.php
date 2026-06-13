<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
    <!-- Hero / Welcome Section with subtle glassmorphism -->
    <div class="mb-8 relative overflow-hidden rounded-2xl border border-slate-200/50 bg-white/40 p-8 backdrop-blur-xl shadow-sm dark:border-slate-800/50 dark:bg-slate-900/40">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-500/10 to-blue-500/10 dark:from-teal-500/5 dark:to-blue-500/5"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl opacity-50 dark:bg-teal-600/10"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl opacity-50 dark:bg-blue-600/10"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Welcome back, <?php echo e(auth()->user()->name ?? 'Admin'); ?>

            </h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400 max-w-2xl text-lg">
                Here's a detailed overview of your operations today. You have <strong class="text-teal-600 dark:text-teal-400"><?php echo e($stats['pending_tasks']); ?> tasks</strong> awaiting approval.
            </p>
        </div>
    </div>

    <!-- Core Metrics Grid -->
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <?php $__currentLoopData = [
            ['Total Employees', $stats['total_employees'], 'from active directory', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.67 0-5 1.34-5 3v2h10v-2c0-1.66-2.33-3-5-3Z', 'from-blue-600 to-indigo-600', 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400', '+12%'],
            ['Active Tasks', $stats['active_tasks'], 'in progress now', 'M9 6h11M9 12h11M9 18h11M4 6l1 1 2-2M4 12l1 1 2-2M4 18l1 1 2-2', 'from-teal-500 to-emerald-600', 'bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400', '+4%'],
            ['Pending Review', $stats['pending_tasks'], 'requires approval', 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'from-amber-500 to-orange-500', 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400', '-2%'],
            ['Overdue Items', $stats['overdue_tasks'], 'critical attention', 'M12 9v4M12 17h.01M10.3 4.3 2.4-1.3 2.4 1.3 5.6 9.7c.8 1.4-.2 3.2-1.9 3.2H5.1c-1.7 0-2.7-1.8-1.9-3.2l5.6-9.7Z', 'from-rose-500 to-red-600', 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400', '+1%'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $hint, $path, $gradient, $badgeClass, $trend]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-slate-300 dark:hover:border-slate-700">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-gradient-to-br <?php echo e($gradient); ?> opacity-10 blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
                
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400"><?php echo e($label); ?></p>
                        <div class="mt-4 flex items-baseline gap-2">
                            <p class="text-4xl font-black tracking-tight text-slate-900 dark:text-white"><?php echo e($value); ?></p>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold <?php echo e($badgeClass); ?>">
                                <?php echo e($trend); ?>

                            </span>
                        </div>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br <?php echo e($gradient); ?> shadow-inner shadow-white/20">
                        <svg class="size-6 text-white drop-shadow-md" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo e($path); ?>"/></svg>
                    </div>
                </div>
                <div class="mt-5 flex items-center text-sm">
                    <span class="text-slate-500 font-medium dark:text-slate-400"><?php echo e($hint); ?></span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Analytics Section -->
    <div class="mt-8 grid gap-8 xl:grid-cols-[1.5fr_1fr]">
        <div class="flex flex-col rounded-2xl border border-slate-200/60 bg-white p-7 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Task Completion Trends</h2>
                    <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Weekly operational performance</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-1.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 dark:bg-slate-800/50 dark:text-slate-300 dark:ring-slate-700">
                        <span class="h-2 w-2 rounded-full bg-teal-500"></span>
                        <?php echo e($stats['completed_tasks']); ?> Total Completed
                    </span>
                </div>
            </div>
            <div class="relative w-full flex-1 min-h-[300px]">
                <canvas id="taskChart"></canvas>
            </div>
        </div>
        
        <div class="flex flex-col rounded-2xl border border-slate-200/60 bg-white p-7 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Recent Activity</h2>
                    <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Latest task updates</p>
                </div>
                <a href="<?php echo e(route('tasks.index')); ?>" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 transition-colors">
                    View all 
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
            <div class="flex-1 space-y-5 overflow-y-auto pr-2">
                <?php $__empty_1 = true; $__currentLoopData = $stats['recent_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('tasks.show', $task)); ?>" class="group flex items-start gap-4 rounded-xl p-3 -mx-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <div class="relative mt-1 flex size-10 shrink-0 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">
                            <?php if(in_array($task->status, ['completed'])): ?>
                                <div class="absolute inset-0 rounded-full bg-emerald-500/20 animate-pulse"></div>
                                <svg class="size-5 text-emerald-600 dark:text-emerald-400 relative z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                            <?php elseif(in_array($task->status, ['overdue'])): ?>
                                <div class="absolute inset-0 rounded-full bg-rose-500/20 animate-pulse"></div>
                                <svg class="size-5 text-rose-600 dark:text-rose-400 relative z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                            <?php else: ?>
                                <div class="absolute inset-0 rounded-full bg-blue-500/20"></div>
                                <svg class="size-5 text-blue-600 dark:text-blue-400 relative z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-bold text-slate-900 group-hover:text-teal-600 transition-colors dark:text-white dark:group-hover:text-teal-400"><?php echo e($task->title); ?></p>
                                <span class="inline-flex shrink-0 items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    <?php echo e(str_replace('_', ' ', $task->status)); ?>

                                </span>
                            </div>
                            <p class="mt-1 truncate text-xs font-medium text-slate-500 dark:text-slate-400">
                                <?php echo e($task->assignee?->user?->name ?? 'Unassigned'); ?> 
                                <span class="mx-1 text-slate-300 dark:text-slate-600">•</span> 
                                <?php echo e($task->customer?->name ?? 'Internal'); ?>

                            </p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="flex h-full flex-col items-center justify-center py-8 text-center">
                        <div class="rounded-full bg-slate-100 p-4 dark:bg-slate-800">
                            <svg class="size-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                        <p class="mt-4 text-sm font-medium text-slate-900 dark:text-white">All caught up!</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">No recent activity to show.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            const textColor = isDark ? '#94a3b8' : '#64748b';
            
            // Create gradient
            const ctx = document.getElementById('taskChart').getContext('2d');
            const tealGradient = ctx.createLinearGradient(0, 0, 0, 400);
            tealGradient.addColorStop(0, 'rgba(20, 184, 166, 1)');   // teal-500
            tealGradient.addColorStop(1, 'rgba(20, 184, 166, 0.4)'); 
            
            const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
            blueGradient.addColorStop(0, 'rgba(59, 130, 246, 1)');   // blue-500
            blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.4)');
            
            const amberGradient = ctx.createLinearGradient(0, 0, 0, 400);
            amberGradient.addColorStop(0, 'rgba(245, 158, 11, 1)');  // amber-500
            amberGradient.addColorStop(1, 'rgba(245, 158, 11, 0.4)');
            
            const roseGradient = ctx.createLinearGradient(0, 0, 0, 400);
            roseGradient.addColorStop(0, 'rgba(244, 63, 94, 1)');    // rose-500
            roseGradient.addColorStop(1, 'rgba(244, 63, 94, 0.4)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Active', 'Pending', 'Overdue', 'Completed', 'Today'],
                    datasets: [{
                        label: 'Tasks',
                        data: [<?php echo e($stats['active_tasks']); ?>, <?php echo e($stats['pending_tasks']); ?>, <?php echo e($stats['overdue_tasks']); ?>, <?php echo e($stats['completed_tasks']); ?>, <?php echo e($stats['today_tasks']); ?>],
                        backgroundColor: [blueGradient, amberGradient, roseGradient, tealGradient, blueGradient],
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 40,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {display: false},
                        tooltip: {
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#0f172a',
                            bodyColor: isDark ? '#cbd5e1' : '#334155',
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            titleFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            bodyFont: { size: 13, family: "'Inter', sans-serif" }
                        }
                    }, 
                    scales: {
                        y: {
                            beginAtZero: true, 
                            ticks: {
                                precision: 0,
                                color: textColor,
                                font: { family: "'Inter', sans-serif", weight: '500' }
                            },
                            grid: { color: gridColor, drawBorder: false },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                color: textColor,
                                font: { family: "'Inter', sans-serif", weight: '600' }
                            },
                            grid: { display: false },
                            border: { display: false }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/dashboard/index.blade.php ENDPATH**/ ?>