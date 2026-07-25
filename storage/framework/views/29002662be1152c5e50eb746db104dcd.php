<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Task Board']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Board']); ?>
    <div class="mb-5 flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
        <form class="grid gap-2 sm:grid-cols-2 lg:grid-cols-5">
            <input class="field" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search tasks">
            <select class="field" name="status"><option value="">All status</option><?php $__currentLoopData = \App\Models\Task::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status')===$status): echo 'selected'; endif; ?>><?php echo e(str_replace('_',' ',$status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <select class="field" name="priority"><option value="">All priority</option><?php $__currentLoopData = \App\Models\Task::PRIORITIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($priority); ?>" <?php if(request('priority')===$priority): echo 'selected'; endif; ?>><?php echo e($priority); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <select class="field" name="department_id"><option value="">Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
            <button class="btn btn-muted">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                Filter
            </button>
        </form>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create tasks')): ?><button class="btn btn-primary" x-data x-on:click="$dispatch('open-modal', 'task-modal')"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>New task</button><?php endif; ?>
    </div>

    <div class="grid gap-4 xl:grid-cols-4">
        <?php $__currentLoopData = ['new' => 'New', 'in_progress' => 'In Progress', 'pending_approval' => 'Approval', 'overdue' => 'Overdue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="min-h-72 rounded-lg border border-slate-200 bg-slate-100/70 p-3 dark:border-slate-800 dark:bg-slate-900/60">
                <div class="mb-3 flex items-center justify-between"><h2 class="text-sm font-semibold"><?php echo e($label); ?></h2><span class="badge bg-white text-slate-600 dark:bg-slate-950 dark:text-slate-300"><?php echo e($tasks->where('status', $key)->count()); ?></span></div>
                <div class="space-y-3">
                    <?php $__currentLoopData = $tasks->where('status', $key); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('tasks.show', $task)); ?>" class="block rounded-lg border border-slate-200 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-950 dark:hover:border-teal-900">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-semibold"><?php echo e($task->title); ?></h3>
                                <span class="badge <?php echo e(in_array($task->priority, ['urgent','critical']) ? 'bg-rose-50 text-rose-700 dark:bg-rose-950 dark:text-rose-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300'); ?>"><?php echo e($task->priority); ?></span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500"><?php echo e($task->assignee?->user?->name ?? 'Unassigned'); ?> · <?php echo e($task->deadline_at?->format('M j') ?? 'No deadline'); ?></p>
                            <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-slate-800"><div class="h-2 rounded-full bg-teal-600" style="width: <?php echo e($task->progress); ?>%"></div></div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4"><?php echo e($tasks->links()); ?></div>

    <div x-data="{open:false}" x-on:open-modal.window="open = $event.detail === 'task-modal'" x-show="open" class="fixed inset-0 z-40 grid place-items-center bg-slate-950/60 p-4" style="display:none">
        <form method="POST" action="<?php echo e(route('tasks.store')); ?>" class="card max-h-[92vh] w-full max-w-3xl overflow-y-auto p-5">
            <?php echo csrf_field(); ?>
            <div class="mb-4 flex items-center justify-between"><h2 class="font-semibold">New task</h2><button class="btn btn-muted px-2.5" type="button" x-on:click="open=false" title="Close"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div>
            <div class="grid gap-3 sm:grid-cols-2">
                <input class="field sm:col-span-2" name="title" placeholder="Task title" required>
                <textarea class="field sm:col-span-2" name="description" placeholder="Description"></textarea>
                <select class="field" name="priority"><?php $__currentLoopData = \App\Models\Task::PRIORITIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($priority); ?>"><?php echo e(ucfirst($priority)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <input class="field" name="deadline_at" type="datetime-local">
                <select class="field" name="assigned_employee_id"><option value="">Assignee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>"><?php echo e($employee->user->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <select class="field" name="customer_id"><option value="">Customer</option><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <select class="field" name="department_id"><option value="">Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <input class="field" name="progress" type="number" min="0" max="100" value="0">
            </div>
            <div class="mt-4 flex justify-end"><button class="btn btn-primary"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Create task</button></div>
        </form>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/tasks/index.blade.php ENDPATH**/ ?>