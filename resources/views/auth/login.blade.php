<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — {{ $businessName ?? 'JewelERP' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4">
<div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-6 text-center border-b border-amber-500/30">
        <div class="inline-flex w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-yellow-600 items-center justify-center text-slate-950 font-bold text-2xl mb-2">✦</div>
        <h1 class="text-xl font-bold text-white">{{ $businessName ?? 'JewelERP' }}</h1>
        <p class="text-xs text-amber-300/90 mt-1">{{ $businessTagline ?? 'Jewellery Suite' }}</p>
    </div>

    <div class="p-6">
        @if(session('status'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-3 py-2 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm px-3 py-2 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@jewelerp.in" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>
            <div class="flex items-center justify-between text-xs text-slate-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                    <span>Keep me signed in</span>
                </label>
            </div>
            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">Sign In</button>
        </form>
    </div>
</div>
</body>
</html>
