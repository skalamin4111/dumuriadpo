<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Task Detail']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Detail']); ?>
    <div class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <section class="surface p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div><h2 class="text-2xl font-bold"><?php echo e($task->title); ?></h2><p class="mt-1 text-sm text-slate-500"><?php echo e($task->customer?->name ?? 'Internal task'); ?></p></div>
                <span class="badge w-fit bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-200"><?php echo e(str_replace('_', ' ', $task->status)); ?></span>
            </div>
            <p class="mt-5 whitespace-pre-line text-slate-700 dark:text-slate-300"><?php echo e($task->description ?: 'No description provided.'); ?></p>
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div><p class="text-xs text-slate-500">Assignee</p><p class="font-medium"><?php echo e($task->assignee?->user?->name ?? '-'); ?></p></div>
                <div><p class="text-xs text-slate-500">Priority</p><p class="font-medium"><?php echo e($task->priority); ?></p></div>
                <div><p class="text-xs text-slate-500">Deadline</p><p class="font-medium"><?php echo e($task->deadline_at?->format('M j, Y g:i A') ?? '-'); ?></p></div>
            </div>
        </section>
        <aside class="space-y-4">
            <form method="POST" action="<?php echo e(route('tasks.update', $task)); ?>" class="surface p-5">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <h2 class="mb-4 font-semibold">Update progress</h2>
                <select class="field mb-3" name="status"><?php $__currentLoopData = \App\Models\Task::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if($task->status===$status): echo 'selected'; endif; ?>><?php echo e(str_replace('_',' ',$status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <input class="field mb-3" name="progress" type="number" min="0" max="100" value="<?php echo e($task->progress); ?>">
                <textarea class="field mb-3" name="delay_reason" placeholder="Delay reason"><?php echo e($task->delay_reason); ?></textarea>
                <input type="hidden" name="title" value="<?php echo e($task->title); ?>"><input type="hidden" name="priority" value="<?php echo e($task->priority); ?>">
                <button class="btn btn-primary w-full"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Save update</button>
            </form>
            <div class="surface p-5"><h2 class="font-semibold">Checklist</h2><div class="mt-3 space-y-2"><?php $__empty_1 = true; $__currentLoopData = $task->checklist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><label class="flex items-center gap-2 text-sm"><input class="rounded border-slate-300 text-teal-600 focus:ring-teal-500" type="checkbox" <?php if($item->is_completed): echo 'checked'; endif; ?>> <?php echo e($item->title); ?></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-sm text-slate-500">No checklist items.</p><?php endif; ?></div></div>
        </aside>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/tasks/show.blade.php ENDPATH**/ ?>