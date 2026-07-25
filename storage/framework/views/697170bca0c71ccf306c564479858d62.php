<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>New Password - DPO ERP</title><?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?></head>
<body class="grid min-h-screen place-items-center bg-slate-950 p-5 text-white">
    <form method="POST" action="<?php echo e(route('password.update')); ?>" class="w-full max-w-md rounded-lg border border-slate-800 bg-slate-900 p-6">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <h1 class="text-2xl font-bold">Create new password</h1>
        <input class="field mt-5" name="email" type="email" placeholder="Email" required autofocus>
        <input class="field mt-3" name="password" type="password" placeholder="New password" required>
        <input class="field mt-3" name="password_confirmation" type="password" placeholder="Confirm password" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-rose-300"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-rose-300"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <button class="btn btn-primary mt-5 w-full">Update password</button>
    </form>
</body>
</html>
<?php /**PATH /home/sahil/development/office_project/dpoerp/resources/views/auth/reset-password.blade.php ENDPATH**/ ?>