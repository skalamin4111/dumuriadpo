<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Dashboard']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => 'Dashboard']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="theme" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title); ?> - <?php echo e(config('app.name')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
    <div class="min-h-screen lg:grid lg:grid-cols-[17rem_1fr]">
        <aside x-data="{ mobileMenuOpen: false }" class="border-b border-slate-200 bg-white/95 backdrop-blur dark:border-slate-800 dark:bg-slate-900/95 lg:sticky lg:top-0 lg:min-h-screen lg:border-b-0 lg:border-r">
            <div class="flex h-16 items-center justify-between px-5">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex min-w-0 items-center gap-3 font-bold">
                    <span class="grid size-10 shrink-0 place-items-center rounded-md bg-teal-600 text-white shadow-sm">D</span>
                    <span class="truncate">DPO ERP</span>
                </a>
                <button type="button" class="btn btn-muted px-2.5 lg:hidden" x-on:click="mobileMenuOpen = !mobileMenuOpen" title="Menu">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
            <nav x-data="{ servicesOpen: true }" x-bind:class="mobileMenuOpen ? 'block' : 'hidden lg:block'" class="space-y-1 px-3 pb-5">
                <?php $__currentLoopData = [
                    ['Dashboard', 'dashboard', 'dashboard', 'M4 13h6V4H4v9Zm0 7h6v-5H4v5Zm10 0h6v-9h-6v9Zm0-11h6V4h-6v5Z'],
                    ['Employees', 'employees.index', 'employees.*', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.67 0-5 1.34-5 3v2h10v-2c0-1.66-2.33-3-5-3Zm8 0c-.32 0-.63.02-.94.07 1.18.85 1.94 1.95 1.94 3.18V18h4v-2c0-1.66-2.33-3-5-3Z'],
                    ['Customers', 'customers.index', 'customers.*', 'M4 6h16v12H4V6Zm3 4h5M7 14h8M16 10h1'],
                    ['Task Board', 'tasks.index', 'tasks.*', 'M9 6h11M9 12h11M9 18h11M4 6l1 1 2-2M4 12l1 1 2-2M4 18l1 1 2-2'],
                    ['Calendar', 'calendar', 'calendar', 'M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z'],
                    ['Reminders', 'reminders.index', 'reminders.*', 'M12 6v6l4 2M5 13a7 7 0 1 0 2.05-4.95M5 5v4h4'],
                    ['Reports', 'reports.index', 'reports.*', 'M5 19V5M5 19h14M9 16V9M13 16V7M17 16v-4'],
                    ['Settings', 'settings', 'settings', 'M12 15.5A3.5 3.5 0 1 0 12 8a3.5 3.5 0 0 0 0 7.5ZM19 12a7 7 0 0 0-.1-1.18l2.1-1.63-2-3.46-2.47.99a7.15 7.15 0 0 0-2.05-1.18L14.1 3h-4l-.38 2.54a7.15 7.15 0 0 0-2.05 1.18L5.2 5.73l-2 3.46 2.1 1.63A7 7 0 0 0 5.2 12c0 .4.03.8.1 1.18l-2.1 1.63 2 3.46 2.47-.99c.62.5 1.31.9 2.05 1.18l.38 2.54h4l.38-2.54c.74-.28 1.43-.68 2.05-1.18l2.47.99 2-3.46-2.1-1.63c.07-.38.1-.78.1-1.18Z'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $route, $active, $path]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($route)); ?>" class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition <?php echo e(request()->routeIs($active) ? 'bg-teal-50 text-teal-700 dark:bg-teal-950/70 dark:text-teal-200' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'); ?>">
                        <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="<?php echo e($path); ?>"/></svg>
                        <span><?php echo e($label); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div>
                    <button type="button" x-on:click="servicesOpen = ! servicesOpen" class="flex w-full items-center gap-3 rounded-md px-3 py-2.5 text-left text-sm font-medium transition <?php echo e(request()->routeIs('services.*') ? 'bg-teal-50 text-teal-700 dark:bg-teal-950/70 dark:text-teal-200' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'); ?>" aria-controls="services-submenu" x-bind:aria-expanded="servicesOpen.toString()">
                        <svg class="size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M6 7v14h12V7M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M8 11h8M8 15h8"/></svg>
                        <span class="flex-1">Service</span>
                        <svg class="size-4 shrink-0 transition" x-bind:class="{ 'rotate-180': servicesOpen }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div id="services-submenu" x-show="servicesOpen" class="mt-1 space-y-1 pl-8">
                        <?php $__currentLoopData = [
                            ['Bank Asia', 'bank-asia'],
                            ['LSFC', 'lsfc'],
                            ['Computer Training', 'computer-training'],
                            ['Digital Services', 'digital-services'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$service, $slug]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('services.show', $slug)); ?>" class="block rounded-md px-3 py-2 text-sm font-medium transition <?php echo e(request()->routeIs('services.show') && request()->route('service') === $slug ? 'bg-teal-50 text-teal-700 dark:bg-teal-950/70 dark:text-teal-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100'); ?>">
                                <?php echo e($service); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </nav>
        </aside>

        <main>
            <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-4 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90 sm:px-6">
                <div class="min-w-0">
                    <h1 class="text-lg font-semibold"><?php echo e($title); ?></h1>
                    <p class="text-xs text-slate-500"><?php echo e(now()->format('l, M j Y')); ?></p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-muted px-2.5" x-on:click="toggle()" title="Toggle dark mode">
                        <svg class="size-5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v2M12 19v2M5.64 5.64l1.41 1.41M16.95 16.95l1.41 1.41M3 12h2M19 12h2M5.64 18.36l1.41-1.41M16.95 7.05l1.41-1.41"/><circle cx="12" cy="12" r="4"/></svg>
                        <svg class="hidden size-5 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.8A8.5 8.5 0 1 1 11.2 3 6.5 6.5 0 0 0 21 12.8Z"/></svg>
                    </button>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-primary">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17l5-5-5-5M15 12H3M21 3v18"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="p-4 sm:p-6 lg:p-8">
                <?php if(session('status')): ?>
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200"><?php echo e(session('status')); ?></div>
                <?php endif; ?>
                <?php echo e($slot); ?>

            </section>
        </main>
    </div>
</body>
</html>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/components/app-layout.blade.php ENDPATH**/ ?>