<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Source of Fund Declarations (আয়ের উৎস ঘোষণা-পত্র)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Source of Fund Declarations (আয়ের উৎস ঘোষণা-পত্র)']); ?>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="/services/bank-asia" class="btn btn-muted px-2.5">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Source of Fund (আয়ের উৎস ঘোষণা-পত্র)</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Manage Bank Asia Source of Fund declarations and Transaction Awareness forms.</p>
            </div>
        </div>
        <div>
            <a href="<?php echo e(route('bank-asia.ac-creations.create')); ?>" class="btn btn-primary inline-flex items-center gap-2">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Declaration
            </a>
        </div>
    </div>

    
    <form action="<?php echo e(route('bank-asia.ac-creations.index')); ?>" method="GET" class="surface p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Search</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by customer name, NID, phone or account no..." class="field">
            </div>
            <div class="w-full md:w-48">
                <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Status</label>
                <select name="status" class="field">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="submitted" <?php echo e(request('status') === 'submitted' ? 'selected' : ''); ?>>Submitted</option>
                    <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="btn btn-primary w-full md:w-auto px-5">Filter</button>
                <a href="<?php echo e(route('bank-asia.ac-creations.index')); ?>" class="btn btn-muted w-full md:w-auto px-4 text-center">Reset</a>
            </div>
        </div>
    </form>

    
    <div class="surface overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 dark:border-slate-800 dark:bg-slate-900/50 text-slate-500 font-semibold uppercase text-xs">
                        <th class="p-4">Date</th>
                        <th class="p-4">Account Type</th>
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">NID/ID</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Account / Customer ID</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $acCreations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="p-4 whitespace-nowrap"><?php echo e($ac->date->format('Y-m-d')); ?></td>
                            <td class="p-4">
                                <?php if($ac->account_type === 'new'): ?>
                                    <span class="inline-flex items-center rounded bg-sky-50 px-2 py-0.5 text-xs font-semibold text-sky-700 dark:bg-sky-950/70 dark:text-sky-300">নতুন (New)</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded bg-zinc-100 px-2 py-0.5 text-xs font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">ডরমেন্ট (Dormant)</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 font-bold text-slate-900 dark:text-white">
                                <?php echo e($ac->applicant_name_bn); ?>

                            </td>
                            <td class="p-4 font-mono text-xs"><?php echo e($ac->nid_number); ?></td>
                            <td class="p-4 font-semibold"><?php echo e($ac->mobile_number); ?></td>
                            <td class="p-4">
                                <div class="text-xs">
                                    <span class="text-slate-400">A/C:</span> <?php echo e($ac->account_number ?: 'N/A'); ?>

                                </div>
                                <div class="text-xs mt-0.5">
                                    <span class="text-slate-400">Cust ID:</span> <?php echo e($ac->customer_id ?: 'N/A'); ?>

                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold uppercase
                                    <?php if($ac->status === 'approved'): ?> bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300
                                    <?php elseif($ac->status === 'rejected'): ?> bg-red-50 text-red-700 dark:bg-red-950/70 dark:text-red-300
                                    <?php elseif($ac->status === 'submitted'): ?> bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300
                                    <?php else: ?> bg-amber-50 text-amber-700 dark:bg-amber-950/70 dark:text-amber-300 <?php endif; ?>">
                                    <?php echo e($ac->status); ?>

                                </span>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('bank-asia.ac-creations.show', $ac)); ?>" class="btn btn-muted py-1.5 px-3 text-xs flex items-center gap-1">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        View & Print
                                    </a>
                                    <a href="<?php echo e(route('bank-asia.ac-creations.edit', $ac)); ?>" class="btn btn-muted py-1.5 px-3 text-xs flex items-center gap-1">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('bank-asia.ac-creations.destroy', $ac)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this declaration?');" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-muted hover:text-red-600 dark:hover:text-red-400 py-1.5 px-3 text-xs flex items-center gap-1">
                                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center py-4">
                                    <svg class="size-12 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    <p class="font-semibold text-slate-700 dark:text-slate-300">No declarations found</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Try refining your search terms or create a new declaration.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($acCreations->hasPages()): ?>
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                <?php echo e($acCreations->links()); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/ac-creations/index.blade.php ENDPATH**/ ?>