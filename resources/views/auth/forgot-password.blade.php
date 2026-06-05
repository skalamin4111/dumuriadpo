<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Reset Password - DPO ERP</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="grid min-h-screen place-items-center bg-slate-950 p-5 text-white">
    <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-md rounded-lg border border-slate-800 bg-slate-900 p-6">
        @csrf
        <h1 class="text-2xl font-bold">Reset password</h1>
        <p class="mt-1 text-sm text-slate-400">Enter your email and DPO ERP will send a reset link.</p>
        @if(session('status'))<div class="mt-4 rounded-lg bg-emerald-950 p-3 text-sm text-emerald-200">{{ session('status') }}</div>@endif
        <input class="field mt-5" name="email" type="email" placeholder="Email" required autofocus>
        @error('email')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
        <button class="btn btn-primary mt-5 w-full">Send reset link</button>
        <a class="mt-4 block text-center text-sm text-sky-300" href="{{ route('login') }}">Back to login</a>
    </form>
</body>
</html>
