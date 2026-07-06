<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Register Savings Certificate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Register Savings Certificate']); ?>
    <div class="mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('bank-asia.shonchoy-potros.index')); ?>" class="btn btn-muted px-2.5">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Register Savings Certificate</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Fill in the details to register a new savings certificate (Shonchoy Potro) record.</p>
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

    <form action="<?php echo e(route('bank-asia.shonchoy-potros.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">1. Purchaser Details</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Purchaser Name <span class="text-red-500">*</span></label>
                    <input type="text" name="purchaser_name" class="field" value="<?php echo e(old('purchaser_name')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Purchaser NID <span class="text-red-500">*</span></label>
                    <input type="text" name="purchaser_nid" class="field" value="<?php echo e(old('purchaser_nid')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="purchaser_phone" class="field" value="<?php echo e(old('purchaser_phone')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="purchaser_dob" class="field" value="<?php echo e(old('purchaser_dob')); ?>" required>
                </div>
                <div class="sm:col-span-2 lg:col-span-4">
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Address <span class="text-red-500">*</span></label>
                    <textarea name="purchaser_address" rows="3" class="field" required><?php echo e(old('purchaser_address')); ?></textarea>
                </div>
            </div>
        </section>

        
        <section class="surface p-6" x-data="{
            certType: '<?php echo e(old('certificate_type', 'family')); ?>',
            purchaseDate: '<?php echo e(old('purchase_date', '')); ?>',
            maturityDate: '<?php echo e(old('maturity_date', '')); ?>',
            
            updateMaturity() {
                if (this.purchaseDate) {
                    const pDate = new Date(this.purchaseDate);
                    // Standard Shonchoy Potro duration is 5 years, Pensioner is 5 years, 3-Month is 3 years
                    const durationYears = (this.certType === '3_month_interest') ? 3 : 5;
                    pDate.setFullYear(pDate.getFullYear() + durationYears);
                    this.maturityDate = pDate.toISOString().split('T')[0];
                }
            }
        }">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">2. Certificate details</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Certificate Type <span class="text-red-500">*</span></label>
                    <select name="certificate_type" class="field" x-model="certType" @change="updateMaturity()" required>
                        <?php $__currentLoopData = \App\Models\BankAsiaShonchoyPotro::CERTIFICATE_TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>"><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Certificate Number <span class="text-red-500">*</span></label>
                    <input type="text" name="certificate_number" class="field" value="<?php echo e(old('certificate_number')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Registration Number <span class="text-red-500">*</span></label>
                    <input type="text" name="registration_number" class="field" value="<?php echo e(old('registration_number')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Purchase Date <span class="text-red-500">*</span></label>
                    <input type="date" name="purchase_date" class="field" x-model="purchaseDate" @change="updateMaturity()" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Maturity Date <span class="text-red-500">*</span></label>
                    <input type="date" name="maturity_date" class="field" x-model="maturityDate" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Purchase Amount <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="purchase_amount" class="field" placeholder="BDT" value="<?php echo e(old('purchase_amount')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Interest Rate (%)</label>
                    <input type="number" step="0.01" name="interest_rate" class="field" placeholder="e.g., 11.52" value="<?php echo e(old('interest_rate')); ?>">
                </div>
            </div>
        </section>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">3. Nominee & Attachment details</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nominee Name <span class="text-red-500">*</span></label>
                    <input type="text" name="nominee_name" class="field" value="<?php echo e(old('nominee_name')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Relationship <span class="text-red-500">*</span></label>
                    <input type="text" name="nominee_relation" class="field" placeholder="e.g., Wife, Son" value="<?php echo e(old('nominee_relation')); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Share Percent (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominee_share_percent" class="field" value="<?php echo e(old('nominee_share_percent', 100)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="field" required>
                        <option value="active" <?php echo e(old('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="matured" <?php echo e(old('status') === 'matured' ? 'selected' : ''); ?>>Matured</option>
                        <option value="encashed" <?php echo e(old('status') === 'encashed' ? 'selected' : ''); ?>>Encashed</option>
                    </select>
                </div>
            </div>
            
            <div class="grid gap-5 sm:grid-cols-2 mt-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Upload Certificate Photocopy / Scan</label>
                    <input type="file" name="document" class="field" accept="image/*,application/pdf">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Accepted: PDF, jpeg, png, jpg, gif (Max: 5MB)</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Notes / Remarks</label>
                    <textarea name="notes" rows="2" class="field" placeholder="Add extra remarks..."><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
        </section>

        <div class="flex gap-4 justify-end">
            <a href="<?php echo e(route('bank-asia.shonchoy-potros.index')); ?>" class="btn btn-muted px-6">Cancel</a>
            <button type="submit" class="btn btn-primary px-8">Save & Register</button>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/shonchoy-potros/create.blade.php ENDPATH**/ ?>