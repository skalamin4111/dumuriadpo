<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>New Password - DPO ERP</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="grid min-h-screen place-items-center bg-slate-950 p-5 text-white">
    <form method="POST" action="{{ route('password.update') }}" class="w-full max-w-md rounded-lg border border-slate-800 bg-slate-900 p-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <h1 class="text-2xl font-bold">Create new password</h1>
        <input class="field mt-5" name="email" type="email" placeholder="Email" required autofocus>
        <input class="field mt-3" name="password" type="password" placeholder="New password" required>
        <input class="field mt-3" name="password_confirmation" type="password" placeholder="Confirm password" required>
        @error('email')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
        @error('password')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
        <button class="btn btn-primary mt-5 w-full">Update password</button>
    </form>
</body>
</html>
