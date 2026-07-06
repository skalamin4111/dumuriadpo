<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'আয়ের উৎস ঘোষণা-পত্র - Edit Declaration']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'আয়ের উৎস ঘোষণা-পত্র - Edit Declaration']); ?>
    <div class="mb-6">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('bank-asia.ac-creations.show', $acCreation)); ?>" class="btn btn-muted px-2.5">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">আয়ের উৎস ঘোষণা-পত্র সম্পাদনা (Edit Declaration)</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Modify details of the Source of Fund declaration for <?php echo e($acCreation->applicant_name_bn); ?>.</p>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400">
            <div class="flex items-center gap-2 font-medium">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
                অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:
            </div>
            <ul class="mt-2 list-inside list-disc text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('bank-asia.ac-creations.update', $acCreation)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">১. ঘোষণা সংক্রান্ত তথ্য (Declaration Details)</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">তারিখ (Date) <span class="text-red-500">*</span></label>
                    <input type="date" name="date" class="field" value="<?php echo e(old('date', $acCreation->date->format('Y-m-d'))); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">হিসাবের ধরণ (Account Type) <span class="text-red-500">*</span></label>
                    <div class="flex gap-4 mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="account_type" value="new" <?php echo e(old('account_type', $acCreation->account_type) === 'new' ? 'checked' : ''); ?> class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">নতুন (New)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="account_type" value="dormant" <?php echo e(old('account_type', $acCreation->account_type) === 'dormant' ? 'checked' : ''); ?> class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">ডরমেন্ট (Dormant)</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">হিসাব নং (Account Number)</label>
                    <input type="text" name="account_number" class="field" placeholder="হিসাব নং (যদি থাকে)" value="<?php echo e(old('account_number', $acCreation->account_number)); ?>">
                </div>
            </div>
        </section>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">২. গ্রাহকের ব্যক্তিগত তথ্য (Customer Personal Details)</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">গ্রাহকের নাম (বাংলা) <span class="text-red-500">*</span></label>
                    <input type="text" name="applicant_name_bn" class="field" placeholder="গ্রাহকের সম্পূর্ণ নাম" value="<?php echo e(old('applicant_name_bn', $acCreation->applicant_name_bn)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">পিতা/স্বামীর নাম <span class="text-red-500">*</span></label>
                    <input type="text" name="father_name" class="field" placeholder="পিতা অথবা স্বামীর নাম" value="<?php echo e(old('father_name', $acCreation->father_name)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">মাতার নাম <span class="text-red-500">*</span></label>
                    <input type="text" name="mother_name" class="field" placeholder="মাতার নাম" value="<?php echo e(old('mother_name', $acCreation->mother_name)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">জাতীয় পরিচয়পত্র/পাসপোর্ট/জন্ম নিবন্ধন নং <span class="text-red-500">*</span></label>
                    <input type="text" name="nid_number" class="field" placeholder="NID / Passport / Birth Reg" value="<?php echo e(old('nid_number', $acCreation->nid_number)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">মোবাইল নম্বর <span class="text-red-500">*</span></label>
                    <input type="text" name="mobile_number" class="field" placeholder="মোবাইল নম্বর" value="<?php echo e(old('mobile_number', $acCreation->mobile_number)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">কাস্টমার আইডি (Customer ID)</label>
                    <input type="text" name="customer_id" class="field" placeholder="কাস্টমার আইডি" value="<?php echo e(old('customer_id', $acCreation->customer_id)); ?>">
                </div>
            </div>
            <div class="grid gap-5 sm:grid-cols-1 mt-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">বর্তমান ঠিকানা <span class="text-red-500">*</span></label>
                    <textarea name="present_address" rows="2" class="field" placeholder="গ্রাম, ডাকঘর, উপজেলা, জেলা" required><?php echo e(old('present_address', $acCreation->present_address)); ?></textarea>
                </div>
            </div>
        </section>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">৩. পেশা ও আয়ের উৎস (Occupation & Source of Fund)</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">বর্তমানে আমার পেশা <span class="text-red-500">*</span></label>
                    <input type="text" name="occupation" class="field" placeholder="যেমন: ব্যবসা, গৃহিণী, কৃষি" value="<?php echo e(old('occupation', $acCreation->occupation)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">আমার আয়ের উৎস মূলত <span class="text-red-500">*</span></label>
                    <input type="text" name="source_of_funds" class="field" placeholder="যেমন: কৃষি কাজ, দোকানের আয়, প্রবাসী অর্থ" value="<?php echo e(old('source_of_funds', $acCreation->source_of_funds)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">আনুমানিক মাসিক আয় (টাকা) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="monthly_income" class="field" placeholder="টাকা" value="<?php echo e(old('monthly_income', $acCreation->monthly_income)); ?>" required>
                </div>
            </div>
        </section>

        
        <section class="surface p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-200 border-b pb-2">৪. এজেন্ট আউটলেট ও যাচাইকরণ (Outlet & Verification Details)</h2>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">এজেন্ট পয়েন্টের নাম ও ঠিকানা <span class="text-red-500">*</span></label>
                    <input type="text" name="outlet_name_address" class="field" value="<?php echo e(old('outlet_name_address', $acCreation->outlet_name_address)); ?>" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">যাচাইকারী এজেন্ট/সিএসও এর নাম</label>
                    <input type="text" name="agent_name" class="field" value="<?php echo e(old('agent_name', $acCreation->agent_name)); ?>">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">পদবী (Designation)</label>
                    <input type="text" name="agent_designation" class="field" value="<?php echo e(old('agent_designation', $acCreation->agent_designation)); ?>">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">মোবাইল নম্বর (Agent/CSO)</label>
                    <input type="text" name="agent_mobile" class="field" value="<?php echo e(old('agent_mobile', $acCreation->agent_mobile)); ?>">
                </div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2 mt-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">অবস্থা (Status) <span class="text-red-500">*</span></label>
                    <select name="status" class="field" required>
                        <option value="pending" <?php echo e(old('status', $acCreation->status) === 'pending' ? 'selected' : ''); ?>>Pending (পেন্ডিং)</option>
                        <option value="submitted" <?php echo e(old('status', $acCreation->status) === 'submitted' ? 'selected' : ''); ?>>Submitted (দাখিলকৃত)</option>
                        <option value="approved" <?php echo e(old('status', $acCreation->status) === 'approved' ? 'selected' : ''); ?>>Approved (অনুমোদিত)</option>
                        <option value="rejected" <?php echo e(old('status', $acCreation->status) === 'rejected' ? 'selected' : ''); ?>>Rejected (প্রত্যাখ্যাত)</option>
                    </select>
                </div>
                
                
                <div x-data="{ preview: '<?php echo e($acCreation->applicant_signature_path ? asset('storage/' . $acCreation->applicant_signature_path) : ''); ?>' }" class="flex flex-col items-center p-4 border border-dashed border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50/50 dark:bg-slate-900/50">
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 text-center">গ্রাহকের স্বাক্ষর (Signature Scan)</span>
                    <div class="w-full h-16 bg-slate-200 dark:bg-slate-800 mb-2 overflow-hidden flex items-center justify-center border border-slate-300 dark:border-slate-700 relative rounded">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!preview">
                            <svg class="size-6 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </template>
                    </div>
                    <label class="btn btn-muted py-1 px-2.5 text-xs cursor-pointer">
                        স্বাক্ষর পরিবর্তন করুন
                        <input type="file" name="applicant_signature" class="hidden" accept="image/*"
                            @change="const file = $event.target.files[0]; if(file) { const r = new FileReader(); r.onload = (e) => { preview = e.target.result; }; r.readAsDataURL(file); }">
                    </label>
                </div>
            </div>
        </section>

        <div class="flex gap-4 justify-end">
            <a href="<?php echo e(route('bank-asia.ac-creations.show', $acCreation)); ?>" class="btn btn-muted px-6">Cancel</a>
            <button type="submit" class="btn btn-primary px-8">হালনাগাদ করুন</button>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/services/bank-asia/ac-creations/edit.blade.php ENDPATH**/ ?>