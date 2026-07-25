<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Reset Password - DPO ERP</title><?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?></head>
<body class="grid min-h-screen place-items-center bg-slate-950 p-5 text-white">
    <form method="POST" action="<?php echo e(route('password.email')); ?>" class="w-full max-w-md rounded-lg border border-slate-800 bg-slate-900 p-6">
        <?php echo csrf_field(); ?>
        <h1 class="text-2xl font-bold">Reset password</h1>
        <p class="mt-1 text-sm text-slate-400">Enter your email and DPO ERP will send a reset link.</p>
        <?php if(session('status')): ?><div class="mt-4 rounded-lg bg-emerald-950 p-3 text-sm text-emerald-200"><?php echo e(session('status')); ?></div><?php endif; ?>
        <input class="field mt-5" name="email" type="email" placeholder="Email" required autofocus>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-rose-300"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <button class="btn btn-primary mt-5 w-full">Send reset link</button>
        <a class="mt-4 block text-center text-sm text-sky-300" href="<?php echo e(route('login')); ?>">Back to login</a>
    </form>
</body>
</html>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>