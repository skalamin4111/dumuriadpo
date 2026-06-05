<!DOCTYPE html>
<html lang="en" x-data="theme" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DPO ERP</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <main class="grid min-h-screen lg:grid-cols-[1.05fr_.95fr]">
        <section class="relative hidden overflow-hidden bg-[url('https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1500&q=80')] bg-cover bg-center lg:block">
            <div class="absolute inset-0 bg-slate-950/50"></div>
            <div class="relative flex h-full flex-col justify-between p-12">
                <a href="<?php echo e(route('login')); ?>" class="flex items-center gap-3 text-lg font-bold">
                    <span class="grid size-11 place-items-center rounded-md bg-teal-500 text-white shadow-lg shadow-teal-950/30">D</span>
                    DPO ERP
                </a>
                <div>
                    <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-teal-100">Operations, CRM, and daily work control</p>
                    <h1 class="max-w-2xl text-5xl font-bold leading-tight">DPO ERP</h1>
                    <p class="mt-4 max-w-xl text-lg text-slate-200">A focused workspace for teams, customers, tasks, reports, and approvals.</p>
                </div>
            </div>
        </section>
        <section class="flex items-center justify-center px-5 py-10">
            <form method="POST" action="<?php echo e(route('login.store')); ?>" class="w-full max-w-md rounded-lg border border-slate-800 bg-slate-900/95 p-6 shadow-2xl shadow-black/30">
                <?php echo csrf_field(); ?>
                <div class="mb-6">
                    <div class="mb-4 grid size-11 place-items-center rounded-md bg-teal-600 font-bold shadow-sm">D</div>
                    <h2 class="text-2xl font-bold">Sign in</h2>
                    <p class="mt-1 text-sm text-slate-400">Demo: admin@dpoerp.test / password</p>
                </div>
                <label class="mb-4 block">
                    <span class="mb-1 block text-sm text-slate-300">Email</span>
                    <input class="field" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-sm text-rose-300"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>
                <label class="mb-4 block">
                    <span class="mb-1 block text-sm text-slate-300">Password</span>
                    <input class="field" type="password" name="password" required>
                </label>
                <label class="mb-6 flex items-center gap-2 text-sm text-slate-300">
                    <input class="rounded border-slate-600 bg-slate-950 text-sky-600" type="checkbox" name="remember">
                    Remember me
                </label>
                <button class="btn btn-primary w-full">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17l5-5-5-5M15 12H3M21 3v18"/></svg>
                    Login
                </button>
                <a class="mt-4 block text-center text-sm text-teal-300 hover:text-teal-200" href="<?php echo e(route('password.request')); ?>">Forgot password?</a>
            </form>
        </section>
    </main>
</body>
</html>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/auth/login.blade.php ENDPATH**/ ?>