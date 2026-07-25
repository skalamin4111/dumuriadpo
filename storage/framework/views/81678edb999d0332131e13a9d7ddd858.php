<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Bank Asia - TP Updates']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Bank Asia - TP Updates']); ?>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">TP Updates</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage transaction profile update applications.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('bank-asia.tp-updates.create')); ?>" class="btn btn-primary">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                New TP Update
            </a>
        </div>
    </div>

    <div class="sm:bg-white sm:dark:bg-slate-900 sm:shadow-sm sm:border sm:border-slate-200 sm:dark:border-slate-800 sm:rounded-xl">
        <div class="w-full">
            <table class="w-full text-left text-sm block sm:table">
                <thead class="hidden sm:table-header-group">
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400">
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Date</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Account Name</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Account Number</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Type</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Amount</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="block sm:table-row-group space-y-4 sm:space-y-0 sm:divide-y sm:divide-slate-200 dark:sm:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $tpUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $regularTypes = [];
                            $regularFreqs = [];
                            if ($update->regular_daily_tx_count || $update->regular_monthly_tx_count) $regularTypes[] = 'Deposit';
                            if ($update->regular_withdrawal_daily_count || $update->regular_withdrawal_monthly_count) $regularTypes[] = 'Withdraw';
                            if ($update->regular_transfer_daily_count || $update->regular_transfer_monthly_count) $regularTypes[] = 'Transfer';
                            
                            if ($update->regular_daily_tx_count || $update->regular_withdrawal_daily_count || $update->regular_transfer_daily_count) $regularFreqs[] = 'Daily';
                            if ($update->regular_monthly_tx_count || $update->regular_withdrawal_monthly_count || $update->regular_transfer_monthly_count) $regularFreqs[] = 'Monthly';

                            $oneTimeTypes = [];
                            $oneTimeFreqs = [];
                            if ($update->one_time_cash_deposit_count || $update->one_time_cash_deposit_monthly_count) $oneTimeTypes[] = 'Deposit';
                            if ($update->one_time_cash_withdrawal_count || $update->one_time_cash_withdrawal_monthly_count) $oneTimeTypes[] = 'Withdraw';
                            if ($update->one_time_transfer_count || $update->one_time_transfer_monthly_count) $oneTimeTypes[] = 'Transfer';
                            
                            if ($update->one_time_cash_deposit_count || $update->one_time_cash_withdrawal_count || $update->one_time_transfer_count) $oneTimeFreqs[] = 'Daily';
                            if ($update->one_time_cash_deposit_monthly_count || $update->one_time_cash_withdrawal_monthly_count || $update->one_time_transfer_monthly_count) $oneTimeFreqs[] = 'Monthly';

                            $amount = $update->total_amount ?: max(
                                $update->regular_daily_tx_amount + $update->one_time_cash_deposit_amount,
                                $update->regular_withdrawal_daily_amount + $update->one_time_cash_withdrawal_amount,
                                $update->regular_transfer_daily_amount + $update->one_time_transfer_amount
                            );
                        ?>
                        <tr class="block sm:table-row bg-white dark:bg-slate-900 shadow-sm sm:shadow-none border border-slate-200 dark:border-slate-800 sm:border-0 rounded-xl sm:rounded-none p-4 sm:p-0 transition hover:bg-slate-50 dark:hover:bg-slate-800">
                            <td class="flex sm:table-cell items-center gap-3 sm:gap-0 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                <span class="sm:hidden font-medium text-xs text-slate-500 w-24 shrink-0">Date:</span>
                                <span><?php echo e($update->date); ?></span>
                            </td>
                            <td class="flex sm:table-cell items-center gap-3 sm:gap-0 sm:px-4 py-2 sm:py-3 font-medium whitespace-nowrap">
                                <span class="sm:hidden font-medium text-xs text-slate-500 w-24 shrink-0">Name:</span>
                                <span class="text-slate-900 dark:text-slate-100"><?php echo e($update->account_name); ?></span>
                            </td>
                            <td class="flex sm:table-cell items-center gap-3 sm:gap-0 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                <span class="sm:hidden font-medium text-xs text-slate-500 w-24 shrink-0">A/C Number:</span>
                                <span><?php echo e($update->account_number); ?></span>
                            </td>
                            <td class="flex sm:table-cell items-start gap-3 sm:gap-0 sm:px-4 py-2 sm:py-3 align-top">
                                <span class="sm:hidden font-medium text-xs text-slate-500 w-24 shrink-0 mt-1.5">Tx Type:</span>
                                <div class="flex flex-col gap-2 w-full">
                                    <?php if(count($regularTypes) > 0): ?>
                                        <div>
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/20 dark:text-blue-300 dark:ring-blue-900/50">
                                                Regular - <?php echo e(implode(', ', $regularTypes)); ?>

                                            </span>
                                            <?php if(count($regularFreqs) > 0): ?>
                                                <div class="mt-1 text-[11px] font-medium text-slate-500 dark:text-slate-400"><?php echo e(implode(' & ', $regularFreqs)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(count($oneTimeTypes) > 0): ?>
                                        <div>
                                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10 dark:bg-purple-900/20 dark:text-purple-300 dark:ring-purple-900/50">
                                                One Time - <?php echo e(implode(', ', $oneTimeTypes)); ?>

                                            </span>
                                            <?php if(count($oneTimeFreqs) > 0): ?>
                                                <div class="mt-1 text-[11px] font-medium text-slate-500 dark:text-slate-400"><?php echo e(implode(' & ', $oneTimeFreqs)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(count($regularTypes) === 0 && count($oneTimeTypes) === 0): ?>
                                        <span class="text-slate-400 text-xs">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="flex sm:table-cell items-center gap-3 sm:gap-0 sm:px-4 py-2 sm:py-3 font-medium align-top whitespace-nowrap">
                                <span class="sm:hidden font-medium text-xs text-slate-500 w-24 shrink-0">Amount:</span>
                                <span><?php echo e($amount > 0 ? '৳ ' . number_format($amount) : '-'); ?></span>
                            </td>
                            <td class="block sm:table-cell sm:px-4 pt-4 pb-2 sm:py-3 mt-3 sm:mt-0 border-t border-slate-200 sm:border-0 dark:border-slate-700 sm:text-right">
                                <div class="flex items-center justify-between sm:justify-end gap-2">
                                    <a href="<?php echo e(route('bank-asia.tp-updates.show', $update)); ?>" class="btn btn-muted px-3 py-1.5 flex-1 sm:flex-none justify-center gap-1.5" title="View / Print">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <span class="sm:hidden text-xs font-medium">View</span>
                                    </a>
                                    <a href="<?php echo e(route('bank-asia.tp-updates.edit', $update)); ?>" class="btn btn-muted px-3 py-1.5 flex-1 sm:flex-none justify-center gap-1.5" title="Edit">
                                        <svg class="size-4 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        <span class="sm:hidden text-xs font-medium text-blue-600 dark:text-blue-400">Edit</span>
                                    </a>
                                    <form action="<?php echo e(route('bank-asia.tp-updates.destroy', $update)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this TP update?');" class="flex-1 sm:flex-none block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-muted px-3 py-1.5 w-full justify-center gap-1.5" title="Delete">
                                            <svg class="size-4 text-red-600 dark:text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            <span class="sm:hidden text-xs font-medium text-red-600 dark:text-red-400">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="block sm:table-row bg-white dark:bg-slate-900 shadow-sm sm:shadow-none border border-slate-200 dark:border-slate-800 sm:border-0 rounded-xl sm:rounded-none">
                            <td colspan="6" class="block sm:table-cell px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                                No TP updates found. Create a new one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($tpUpdates->hasPages()): ?>
            <div class="border-t border-slate-200 p-4 dark:border-slate-800">
                <?php echo e($tpUpdates->links()); ?>

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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/tp-updates/index.blade.php ENDPATH**/ ?>