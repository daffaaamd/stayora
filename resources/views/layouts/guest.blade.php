<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Stayora Resort') }} — Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-charcoal-900 bg-warm-100 antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4">
            <span class="font-display text-3xl font-bold text-charcoal-900 tracking-tight">Stayora</span>
            <span class="text-gold-500 font-display text-lg font-medium">Resort</span>
        </a>
        <p class="text-xs text-charcoal-500">Luxury Hotel & Resort Management System</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xl rounded-2xl border border-charcoal-200">
            {{ $slot }}
        </div>
        <div class="text-center mt-6">
            <p class="text-xs text-charcoal-500">
                Crafted by <span class="font-bold text-gold-700">Daffa Ahmad Baihaqi</span>
            </p>
            <p class="text-[11px] text-charcoal-400 mt-0.5">Stayora Resort Management System</p>
        </div>
    </div>
</body>
</html>
