<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Calendar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Calendar']); ?>
    <div class="grid gap-4 lg:grid-cols-3">
        <?php $__currentLoopData = $tasks->groupBy(fn($task) => $task->deadline_at?->format('Y-m-d')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="surface p-4">
                <h2 class="flex items-center gap-2 font-semibold"><span class="icon-box size-8 text-teal-600 dark:text-teal-300"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z"/></svg></span><?php echo e(\Carbon\Carbon::parse($date)->format('D, M j')); ?></h2>
                <div class="mt-3 space-y-2">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('tasks.show', $task)); ?>" class="block rounded-md border border-slate-100 p-3 text-sm transition hover:border-teal-200 hover:bg-slate-50 dark:border-slate-800 dark:hover:border-teal-900 dark:hover:bg-slate-800">
                            <span class="font-medium"><?php echo e($task->title); ?></span>
                            <span class="mt-1 block text-xs text-slate-500"><?php echo e($task->deadline_at->format('g:i A')); ?> · <?php echo e($task->assignee?->user?->name ?? 'Unassigned'); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/calendar/index.blade.php ENDPATH**/ ?>