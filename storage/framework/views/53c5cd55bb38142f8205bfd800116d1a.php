<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'New TP Update']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'New TP Update']); ?>
    <div class="mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('bank-asia.tp-updates.index')); ?>" class="btn btn-muted px-2.5">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">New TP Update Form</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Fill in the details to generate the TP update application and undertaking.</p>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400">
            <div class="flex items-center gap-2 font-medium">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
                Please correct the following errors:
            </div>
            <ul class="mt-2 list-inside list-disc text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('bank-asia.tp-updates.store')); ?>" method="POST" class="space-y-6 lg:space-y-8"
        x-data="{
            regDepositAmt: '<?php echo e(old('regular_daily_tx_amount', '')); ?>',
            oneTimeDepositAmt: '<?php echo e(old('one_time_cash_deposit_amount', '')); ?>',
            undertakingOpen: <?php echo e(old('animal_quantity') || old('total_amount') ? 'true' : 'false'); ?>,
            undertakingAmount: '<?php echo e(old('total_amount', '')); ?>',
            
            get totalDeposit() {
                return (parseFloat(this.regDepositAmt) || 0) + (parseFloat(this.oneTimeDepositAmt) || 0);
            },
            
            checkUndertaking() {
                if (this.totalDeposit >= 400000) {
                    this.undertakingOpen = true;
                    this.undertakingAmount = this.totalDeposit;
                }
            }
        }"
        x-init="
            $watch('regDepositAmt', value => checkUndertaking());
            $watch('oneTimeDepositAmt', value => checkUndertaking());
        "
    >
        <?php echo csrf_field(); ?>

        
        <section class="surface p-6 mb-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200">Client Information</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" class="field" value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Account Number <span class="text-red-500">*</span></label>
                    <input type="text" name="account_number" class="field" value="<?php echo e(old('account_number')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Account Name <span class="text-red-500">*</span></label>
                    <input type="text" name="account_name" class="field" value="<?php echo e(old('account_name')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Account Type <span class="text-red-500">*</span></label>
                    <select name="account_type" class="field" required>
                        <option value="Savings Account" <?php echo e(old('account_type') == 'Savings Account' ? 'selected' : ''); ?>>Savings Account (সেভিংস একাউন্ট)</option>
                        <option value="Current Account" <?php echo e(old('account_type') == 'Current Account' ? 'selected' : ''); ?>>Current Account (কারেন্ট একাউন্ট)</option>
                        <option value="SND Account" <?php echo e(old('account_type') == 'SND Account' ? 'selected' : ''); ?>>SND Account (এস.এন.ডি একাউন্ট)</option>
                        <option value="Other" <?php echo e(old('account_type') == 'Other' ? 'selected' : ''); ?>>Other (অন্যান্য)</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Client Mobile</label>
                    <input type="text" name="client_mobile" class="field" value="<?php echo e(old('client_mobile')); ?>">
                </div>
            </div>
        </section>

        
        <section class="surface p-6 mb-6" x-data="{ isOpen: <?php echo e((old('regular_daily_tx_count') || old('regular_daily_tx_amount') || old('regular_monthly_tx_count') || old('regular_monthly_tx_amount') || old('regular_withdrawal_daily_count') || old('regular_withdrawal_daily_amount') || old('regular_withdrawal_monthly_count') || old('regular_withdrawal_monthly_amount') || old('regular_transfer_daily_count') || old('regular_transfer_daily_amount') || old('regular_transfer_monthly_count') || old('regular_transfer_monthly_amount')) ? 'true' : 'false'); ?> }">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" x-model="isOpen" class="size-5 rounded border-slate-300 text-teal-600 focus:ring-teal-600 dark:border-slate-600 dark:bg-slate-900">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Regular Transactions (নিয়মিত লেনদেন)</h2>
            </label>
            <div x-show="isOpen" style="display: none;" class="space-y-6 mt-6">
                <!-- Cash Deposit -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Cash Deposit (নগদ জমা)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="regular_daily_tx_count" class="field" value="<?php echo e(old('regular_daily_tx_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="regular_daily_tx_amount" class="field" value="<?php echo e(old('regular_daily_tx_amount')); ?>" x-model="regDepositAmt">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="regular_monthly_tx_count" class="field" value="<?php echo e(old('regular_monthly_tx_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="regular_monthly_tx_amount" class="field" value="<?php echo e(old('regular_monthly_tx_amount')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Cash Withdrawal -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Cash Withdrawal (নগদ উত্তোলন)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="regular_withdrawal_daily_count" class="field" value="<?php echo e(old('regular_withdrawal_daily_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="regular_withdrawal_daily_amount" class="field" value="<?php echo e(old('regular_withdrawal_daily_amount')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="regular_withdrawal_monthly_count" class="field" value="<?php echo e(old('regular_withdrawal_monthly_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="regular_withdrawal_monthly_amount" class="field" value="<?php echo e(old('regular_withdrawal_monthly_amount')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Transfer -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Transfer (স্থানান্তর লেনদেন)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="regular_transfer_daily_count" class="field" value="<?php echo e(old('regular_transfer_daily_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="regular_transfer_daily_amount" class="field" value="<?php echo e(old('regular_transfer_daily_amount')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="regular_transfer_monthly_count" class="field" value="<?php echo e(old('regular_transfer_monthly_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="regular_transfer_monthly_amount" class="field" value="<?php echo e(old('regular_transfer_monthly_amount')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="surface p-6 mb-6" x-data="{ isOpen: <?php echo e((old('one_time_cash_deposit_count') || old('one_time_cash_deposit_amount') || old('one_time_cash_deposit_monthly_count') || old('one_time_cash_deposit_monthly_amount') || old('one_time_cash_withdrawal_count') || old('one_time_cash_withdrawal_amount') || old('one_time_cash_withdrawal_monthly_count') || old('one_time_cash_withdrawal_monthly_amount') || old('one_time_transfer_count') || old('one_time_transfer_amount') || old('one_time_transfer_monthly_count') || old('one_time_transfer_monthly_amount') || old('source_of_funds')) ? 'true' : 'false'); ?> }">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" x-model="isOpen" class="size-5 rounded border-slate-300 text-teal-600 focus:ring-teal-600 dark:border-slate-600 dark:bg-slate-900">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200">One Time Transactions (একবার লেনদেন)</h2>
            </label>
            <div x-show="isOpen" style="display: none;" class="space-y-6 mt-6">
                <!-- Cash Deposit -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Cash Deposit (নগদ জমা)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="one_time_cash_deposit_count" class="field" value="<?php echo e(old('one_time_cash_deposit_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="one_time_cash_deposit_amount" class="field" value="<?php echo e(old('one_time_cash_deposit_amount')); ?>" x-model="oneTimeDepositAmt">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="one_time_cash_deposit_monthly_count" class="field" value="<?php echo e(old('one_time_cash_deposit_monthly_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="one_time_cash_deposit_monthly_amount" class="field" value="<?php echo e(old('one_time_cash_deposit_monthly_amount')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Cash Withdrawal -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Cash Withdrawal (নগদ উত্তোলন)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="one_time_cash_withdrawal_count" class="field" value="<?php echo e(old('one_time_cash_withdrawal_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="one_time_cash_withdrawal_amount" class="field" value="<?php echo e(old('one_time_cash_withdrawal_amount')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="one_time_cash_withdrawal_monthly_count" class="field" value="<?php echo e(old('one_time_cash_withdrawal_monthly_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="one_time_cash_withdrawal_monthly_amount" class="field" value="<?php echo e(old('one_time_cash_withdrawal_monthly_amount')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Transfer -->
                <div>
                    <div class="mt-6 font-medium text-sm text-slate-700 dark:text-slate-300 mb-3 border-b pb-2">Transfer (স্থানান্তর লেনদেন)</div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Tx Count</label>
                            <input type="number" name="one_time_transfer_count" class="field" value="<?php echo e(old('one_time_transfer_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Amount</label>
                            <input type="number" step="1" name="one_time_transfer_amount" class="field" value="<?php echo e(old('one_time_transfer_amount')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Tx Count</label>
                            <input type="number" name="one_time_transfer_monthly_count" class="field" value="<?php echo e(old('one_time_transfer_monthly_count')); ?>">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Monthly Amount</label>
                            <input type="number" step="1" name="one_time_transfer_monthly_amount" class="field" value="<?php echo e(old('one_time_transfer_monthly_amount')); ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div x-show="isOpen" style="display: none;" class="mt-5 border-t pt-5">
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Source of Funds (লেনদেনের তহবিলের উৎস)</label>
                <input type="text" name="source_of_funds" class="field" value="<?php echo e(old('source_of_funds')); ?>">
            </div>
        </section>

        
        <section class="surface p-6 mb-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_undertaking_checked" x-model="undertakingOpen" class="size-5 rounded border-slate-300 text-teal-600 focus:ring-teal-600 dark:border-slate-600 dark:bg-slate-900">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Undertaking Details (অঙ্গীকারনামা)</h2>
            </label>
            <div x-show="undertakingOpen" style="display: none;" class="mt-6">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Animal Quantity (গরুর সংখ্যা)</label>
                        <input type="number" name="animal_quantity" class="field" value="<?php echo e(old('animal_quantity')); ?>">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Total Amount (মোট টাকা)</label>
                        <input type="number" step="1" name="total_amount" class="field" x-model="undertakingAmount">
                    </div>
                </div>
            </div>
        </section>

        
        <section class="surface p-6 mb-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200">Agent Details (এজেন্ট/সিএসও-এর অংশ)</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Agent Name</label>
                    <input type="text" name="agent_name" class="field" value="<?php echo e(old('agent_name', 'মোঃ আলামিন')); ?>">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Designation</label>
                    <input type="text" name="agent_designation" class="field" value="<?php echo e(old('agent_designation', 'সি এস ও')); ?>">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Mobile No</label>
                    <input type="text" name="agent_mobile" class="field" value="<?php echo e(old('agent_mobile', '01955801666')); ?>">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Outlet Name & Address</label>
                    <input type="text" name="outlet_name_address" class="field" value="<?php echo e(old('outlet_name_address', 'ডুমুরিয়া ডি পি ও, খুলনা')); ?>">
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3 pt-2 pb-10">
            <a href="<?php echo e(route('bank-asia.tp-updates.index')); ?>" class="btn btn-muted">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save & Continue to Print
            </button>
        </div>
    </form>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/tp-updates/create.blade.php ENDPATH**/ ?>