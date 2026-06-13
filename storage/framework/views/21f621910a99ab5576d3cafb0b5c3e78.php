<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Employees']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Employees']); ?>
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form class="flex gap-2">
            <input class="field w-64" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search employees">
            <button class="btn btn-muted"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>Filter</button>
        </form>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create employees')): ?>
            <button class="btn btn-primary" x-data x-on:click="$dispatch('open-modal', 'employee-modal')"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM19 8v6M16 11h6"/></svg>Add employee</button>
        <?php endif; ?>
    </div>

    <div class="surface overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="table-head">
                    <tr><th class="px-4 py-3">Employee</th><th class="px-4 py-3">Department</th><th class="px-4 py-3">Designation</th><th class="px-4 py-3">Phone</th><th class="px-4 py-3">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-row">
                            <td class="px-4 py-3"><p class="font-medium"><?php echo e($employee->user->name); ?></p><p class="text-xs text-slate-500"><?php echo e($employee->user->email); ?></p></td>
                            <td class="px-4 py-3"><?php echo e($employee->department?->name ?? '-'); ?></td>
                            <td class="px-4 py-3"><?php echo e($employee->designation ?? '-'); ?></td>
                            <td class="px-4 py-3"><?php echo e($employee->phone ?? '-'); ?></td>
                            <td class="px-4 py-3"><span class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-200"><?php echo e($employee->status); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4"><?php echo e($employees->links()); ?></div>

    <div x-data="{open:false}" x-on:open-modal.window="open = $event.detail === 'employee-modal'" x-show="open" class="fixed inset-0 z-40 grid place-items-center bg-slate-950/60 p-4" style="display:none">
        <form method="POST" action="<?php echo e(route('employees.store')); ?>" enctype="multipart/form-data" class="card w-full max-w-2xl p-5">
            <?php echo csrf_field(); ?>
            <div class="mb-4 flex items-center justify-between"><h2 class="font-semibold">New employee</h2><button class="btn btn-muted px-2.5" type="button" x-on:click="open=false" title="Close"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div>
            <div class="grid gap-3 sm:grid-cols-2">
                <input class="field" name="name" placeholder="Full name" required>
                <input class="field" name="email" type="email" placeholder="Email" required>
                <input class="field" name="password" type="password" placeholder="Password" required>
                <select class="field" name="role"><option>Employee</option><option>Manager</option><option>Admin</option></select>
                <select class="field" name="department_id"><option value="">Department</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <input class="field" name="designation" placeholder="Designation">
                <input class="field" name="phone" placeholder="Phone">
                <input class="field" name="joining_date" type="date">
                <input class="field" name="emergency_contact" placeholder="Emergency contact">
                <select class="field" name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select>
                <input class="field sm:col-span-2" name="profile_photo" type="file" accept="image/*">
                <textarea class="field sm:col-span-2" name="address" placeholder="Address"></textarea>
            </div>
            <div class="mt-4 flex justify-end"><button class="btn btn-primary"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Create employee</button></div>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/employees/index.blade.php ENDPATH**/ ?>