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
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <?php $__currentLoopData = [
            ['Total employees', $stats['total_employees'], 'from active directory', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.67 0-5 1.34-5 3v2h10v-2c0-1.66-2.33-3-5-3Z'],
            ['Active tasks', $stats['active_tasks'], 'new and in progress', 'M9 6h11M9 12h11M9 18h11M4 6l1 1 2-2M4 12l1 1 2-2M4 18l1 1 2-2'],
            ['Pending tasks', $stats['pending_tasks'], 'blocked or approval', 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['Overdue tasks', $stats['overdue_tasks'], 'need attention', 'M12 9v4M12 17h.01M10.3 4.3 2.4-1.3 2.4 1.3 5.6 9.7c.8 1.4-.2 3.2-1.9 3.2H5.1c-1.7 0-2.7-1.8-1.9-3.2l5.6-9.7Z'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $hint, $path]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="surface p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo e($label); ?></p>
                        <p class="mt-3 text-3xl font-bold"><?php echo e($value); ?></p>
                    </div>
                    <span class="icon-box text-teal-600 dark:text-teal-300">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo e($path); ?>"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-500"><?php echo e($hint); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_.75fr]">
        <div class="surface p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Task Completion</h2>
                <span class="text-sm text-slate-500"><?php echo e($stats['completed_tasks']); ?> completed</span>
            </div>
            <canvas id="taskChart" height="110"></canvas>
        </div>
        <div class="surface p-5">
            <h2 class="font-semibold">Recent Activity</h2>
            <div class="mt-4 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $stats['recent_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('tasks.show', $task)); ?>" class="block rounded-md border border-slate-100 p-3 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-medium"><?php echo e($task->title); ?></p>
                            <span class="badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300"><?php echo e(str_replace('_', ' ', $task->status)); ?></span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500"><?php echo e($task->assignee?->user?->name ?? 'Unassigned'); ?> · <?php echo e($task->customer?->name ?? 'Internal'); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-slate-500">No activity yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('taskChart'), {
                type: 'bar',
                data: {
                    labels: ['Active', 'Pending', 'Overdue', 'Completed', 'Today'],
                    datasets: [{
                        label: 'Tasks',
                        data: [<?php echo e($stats['active_tasks']); ?>, <?php echo e($stats['pending_tasks']); ?>, <?php echo e($stats['overdue_tasks']); ?>, <?php echo e($stats['completed_tasks']); ?>, <?php echo e($stats['today_tasks']); ?>],
                        backgroundColor: ['#0f766e', '#ca8a04', '#dc2626', '#16a34a', '#2563eb'],
                        borderRadius: 8
                    }]
                },
                options: {responsive: true, plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true, ticks: {precision: 0}}}}
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