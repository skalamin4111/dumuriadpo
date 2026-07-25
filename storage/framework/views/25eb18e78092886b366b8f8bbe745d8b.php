<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Settings']); ?>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <?php $__currentLoopData = [
            ['Roles and Permissions', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Z'],
            ['Notification Channels', 'M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.7 21a2 2 0 0 1-3.4 0'],
            ['Queue and Scheduler', 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['API Tokens', 'M15 7h3a4 4 0 1 1 0 8h-3M9 7H6a4 4 0 1 0 0 8h3M8 12h8'],
            ['Company Profile', 'M4 21V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v16M16 8h3a1 1 0 0 1 1 1v12M8 9h4M8 13h4M8 17h4'],
            ['Future Modules', 'M12 5v14M5 12h14'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$item, $path]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="surface p-5">
                <div class="mb-4 flex items-center gap-3">
                    <span class="icon-box text-teal-600 dark:text-teal-300"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo e($path); ?>"/></svg></span>
                    <h2 class="font-semibold"><?php echo e($item); ?></h2>
                </div>
                <p class="mt-2 text-sm text-slate-500">Configured through Laravel services and ready for the next ERP expansion stage.</p>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/settings/index.blade.php ENDPATH**/ ?>