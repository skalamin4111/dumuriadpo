<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Customers']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Customers']); ?>
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form class="flex gap-2"><input class="field w-64" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search customers"><button class="btn btn-muted"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>Filter</button></form>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create customers')): ?><button class="btn btn-primary" x-data x-on:click="$dispatch('open-modal', 'customer-modal')"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Add customer</button><?php endif; ?>
    </div>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="surface p-4 transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md dark:hover:border-teal-900">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex min-w-0 gap-3">
                        <span class="icon-box text-teal-600 dark:text-teal-300"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16v12H4V6Zm3 4h5M7 14h8M16 10h1"/></svg></span>
                        <div class="min-w-0"><h2 class="truncate font-semibold"><?php echo e($customer->name); ?></h2><p class="truncate text-sm text-slate-500"><?php echo e($customer->company_name ?? $customer->email); ?></p></div>
                    </div>
                    <span class="badge bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-200"><?php echo e($customer->type); ?></span>
                </div>
                <p class="mt-4 text-sm text-slate-600 dark:text-slate-300"><?php echo e($customer->phone ?? 'No phone'); ?></p>
                <p class="mt-1 text-sm text-slate-500"><?php echo e($customer->tasks_count); ?> tasks</p>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4"><?php echo e($customers->links()); ?></div>

    <div x-data="{open:false}" x-on:open-modal.window="open = $event.detail === 'customer-modal'" x-show="open" class="fixed inset-0 z-40 grid place-items-center bg-slate-950/60 p-4" style="display:none">
        <form method="POST" action="<?php echo e(route('customers.store')); ?>" class="card w-full max-w-2xl p-5">
            <?php echo csrf_field(); ?>
            <div class="mb-4 flex items-center justify-between"><h2 class="font-semibold">New customer</h2><button class="btn btn-muted px-2.5" type="button" x-on:click="open=false" title="Close"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div>
            <div class="grid gap-3 sm:grid-cols-2">
                <input class="field" name="name" placeholder="Name" required><input class="field" name="company_name" placeholder="Company">
                <input class="field" name="phone" placeholder="Phone"><input class="field" name="email" type="email" placeholder="Email">
                <select class="field" name="type"><option value="lead">Lead</option><option value="regular">Regular</option><option value="vip">VIP</option><option value="corporate">Corporate</option></select>
                <select class="field" name="status"><option value="active">Active</option><option value="prospect">Prospect</option><option value="inactive">Inactive</option></select>
                <textarea class="field sm:col-span-2" name="address" placeholder="Address"></textarea>
                <textarea class="field sm:col-span-2" name="notes" placeholder="Notes"></textarea>
            </div>
            <div class="mt-4 flex justify-end"><button class="btn btn-primary"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Create customer</button></div>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/customers/index.blade.php ENDPATH**/ ?>