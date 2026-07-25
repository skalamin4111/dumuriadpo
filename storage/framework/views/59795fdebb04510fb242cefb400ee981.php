<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Reminders']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reminders']); ?>
    <div class="grid gap-5 xl:grid-cols-[24rem_1fr]">
        <section class="surface p-5">
            <div class="mb-4">
                <h2 class="font-semibold">Set customer reminder</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Record office visits, service interest, and next follow-up date.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:border-rose-900 dark:bg-rose-950 dark:text-rose-200">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('reminders.store')); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <select class="field" name="customer_id" required>
                    <option value="">Select customer</option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>" <?php if(old('customer_id') == $customer->id): echo 'selected'; endif; ?>><?php echo e($customer->name); ?><?php echo e($customer->phone ? ' - '.$customer->phone : ''); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select class="field" name="service_section" required>
                    <option value="">Select service section</option>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($slug); ?>" <?php if(old('service_section') === $slug): echo 'selected'; endif; ?>><?php echo e($service); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select class="field" name="contact_type" required>
                    <?php $__currentLoopData = $contactTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(old('contact_type', 'office_visit') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <input class="field" name="title" value="<?php echo e(old('title')); ?>" placeholder="Reminder title" required>

                <textarea class="field min-h-28" name="purpose" placeholder="Why did the customer come or why did the officer call?" required><?php echo e(old('purpose')); ?></textarea>

                <textarea class="field min-h-24" name="follow_up_notes" placeholder="What is needed before the next visit or admission?"><?php echo e(old('follow_up_notes')); ?></textarea>

                <label class="block">
                    <span class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">Next follow-up date and time</span>
                    <input class="field" name="remind_at" type="datetime-local" value="<?php echo e(old('remind_at')); ?>" required>
                </label>

                <button class="btn btn-primary w-full">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v6l4 2M5 13a7 7 0 1 0 2.05-4.95M5 5v4h4"/></svg>
                    Save reminder
                </button>
            </form>
        </section>

        <section class="space-y-4">
            <div class="surface p-4">
                <form class="grid gap-3 md:grid-cols-[1fr_12rem_10rem_auto]">
                    <input class="field" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search customer, phone, or purpose">
                    <select class="field" name="service_section">
                        <option value="">All services</option>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($slug); ?>" <?php if(request('service_section') === $slug): echo 'selected'; endif; ?>><?php echo e($service); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <select class="field" name="status">
                        <option value="">All status</option>
                        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                        <option value="completed" <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>>Completed</option>
                        <option value="cancelled" <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                    </select>
                    <button class="btn btn-muted">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="surface p-4">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-semibold"><?php echo e($reminder->title); ?></h2>
                                    <span class="badge <?php echo e($reminder->status === 'pending' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-200' : ($reminder->status === 'completed' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300')); ?>"><?php echo e(ucfirst($reminder->status)); ?></span>
                                    <span class="badge bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-200"><?php echo e($reminder->service_label); ?></span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300"><?php echo e($reminder->purpose); ?></p>
                                <?php if($reminder->follow_up_notes): ?>
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400"><?php echo e($reminder->follow_up_notes); ?></p>
                                <?php endif; ?>
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-sm text-slate-500 dark:text-slate-400">
                                    <span><?php echo e($reminder->customer?->name ?? 'No customer'); ?></span>
                                    <span><?php echo e($reminder->customer?->phone ?? 'No phone'); ?></span>
                                    <span><?php echo e($reminder->contact_type_label); ?></span>
                                    <span>Officer: <?php echo e($reminder->officer?->name ?? 'Unknown'); ?></span>
                                </div>
                            </div>

                            <div class="shrink-0 space-y-3 lg:text-right">
                                <div>
                                    <p class="text-sm font-semibold <?php echo e($reminder->status === 'pending' && $reminder->remind_at->isPast() ? 'text-rose-600 dark:text-rose-300' : 'text-slate-700 dark:text-slate-200'); ?>"><?php echo e($reminder->remind_at->format('M j, Y g:i A')); ?></p>
                                    <p class="text-xs text-slate-500"><?php echo e($reminder->remind_at->diffForHumans()); ?></p>
                                </div>
                                <?php if($reminder->status === 'pending'): ?>
                                    <div class="flex gap-2 lg:justify-end">
                                        <form method="POST" action="<?php echo e(route('reminders.update', $reminder)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="completed">
                                            <button class="btn btn-primary min-h-9 px-3 py-1.5">Done</button>
                                        </form>
                                        <form method="POST" action="<?php echo e(route('reminders.update', $reminder)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="cancelled">
                                            <button class="btn btn-muted min-h-9 px-3 py-1.5">Cancel</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="surface p-6 text-center text-sm text-slate-500 dark:text-slate-400">No reminders found.</div>
                <?php endif; ?>
            </div>

            <?php echo e($reminders->links()); ?>

        </section>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/reminders/index.blade.php ENDPATH**/ ?>