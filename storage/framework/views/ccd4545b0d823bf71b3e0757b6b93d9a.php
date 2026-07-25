<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Reports']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reports']); ?>
    <div class="grid gap-6 xl:grid-cols-[24rem_1fr]">
        <form method="POST" action="<?php echo e(route('reports.store')); ?>" class="surface p-5">
            <?php echo csrf_field(); ?>
            <h2 class="mb-4 font-semibold">Submit daily report</h2>
            <input class="field mb-3" type="date" name="report_date" value="<?php echo e(today()->toDateString()); ?>" required>
            <textarea class="field mb-3" name="completed_works" placeholder="Completed works" required></textarea>
            <input class="field mb-3" name="time_spent_minutes" type="number" min="0" placeholder="Time spent in minutes" required>
            <textarea class="field mb-3" name="pending_work" placeholder="Pending work"></textarea>
            <textarea class="field mb-3" name="problems_faced" placeholder="Problems faced"></textarea>
            <button class="btn btn-primary w-full"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>Submit report</button>
        </form>
        <div class="surface overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="table-head"><tr><th class="px-4 py-3">Employee</th><th class="px-4 py-3">Date</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Time</th></tr></thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800"><?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr class="table-row"><td class="px-4 py-3"><?php echo e($report->employee?->user?->name); ?></td><td class="px-4 py-3"><?php echo e($report->report_date->format('M j, Y')); ?></td><td class="px-4 py-3"><span class="badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300"><?php echo e(str_replace('_',' ',$report->review_status)); ?></span></td><td class="px-4 py-3"><?php echo e($report->time_spent_minutes); ?> min</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
            </table>
        </div>
    </div>
    <div class="mt-4"><?php echo e($reports->links()); ?></div>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/reports/index.blade.php ENDPATH**/ ?>