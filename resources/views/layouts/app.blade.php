<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Stayora Resort — A Stay Worth Remembering')</title>
    <meta name="description" content="@yield('meta_description', 'Stayora Resort offers premium hotel and resort experience with world-class facilities, elegant rooms, and unforgettable hospitality.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-charcoal-900 bg-white" x-data="{ mobileMenu: false }">
    {{-- Navigation --}}
    <nav class="bg-white border-b border-charcoal-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-display text-xl font-bold text-charcoal-900 tracking-tight">Stayora</span>
                    <span class="text-gold-500 font-display text-sm font-medium">Resort</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm text-charcoal-600 hover:text-charcoal-900 transition-colors {{ request()->routeIs('home') ? 'text-charcoal-900 font-medium' : '' }}">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm text-charcoal-600 hover:text-charcoal-900 transition-colors {{ request()->routeIs('rooms.*') ? 'text-charcoal-900 font-medium' : '' }}">Rooms</a>
                    <a href="{{ route('facilities.index') }}" class="text-sm text-charcoal-600 hover:text-charcoal-900 transition-colors {{ request()->routeIs('facilities.*') ? 'text-charcoal-900 font-medium' : '' }}">Facilities</a>
                    <a href="{{ route('gallery') }}" class="text-sm text-charcoal-600 hover:text-charcoal-900 transition-colors {{ request()->routeIs('gallery') ? 'text-charcoal-900 font-medium' : '' }}">Gallery</a>
                </div>
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative text-charcoal-500 hover:text-charcoal-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ min(auth()->user()->unreadNotifications()->count(), 9) }}</span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-charcoal-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-charcoal-100"><h4 class="text-sm font-semibold text-charcoal-900">Notifications</h4></div>
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                        <div class="px-4 py-3 hover:bg-warm-50 {{ $notification->isRead() ? '' : 'bg-gold-50' }}">
                                            <p class="text-sm font-medium text-charcoal-900">{{ $notification->title }}</p>
                                            <p class="text-xs text-charcoal-500 mt-0.5">{{ Str::limit($notification->message, 60) }}</p>
                                            <p class="text-xs text-charcoal-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    @empty
                                        <p class="px-4 py-6 text-sm text-charcoal-400 text-center">No notifications</p>
                                    @endforelse
                                </div>
                                @if(auth()->user()->notifications()->count() > 0)
                                    <div class="px-4 py-2 border-t border-charcoal-100"><a href="{{ route('customer.notifications') }}" class="text-xs text-gold-600 hover:text-gold-700">View all</a></div>
                                @endif
                            </div>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm text-charcoal-700 hover:text-charcoal-900 transition-colors">
                                <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-7 h-7 rounded-full object-cover">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-charcoal-100 py-1 z-50">
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-charcoal-700 hover:bg-warm-50">Dashboard</a>
                                    <a href="{{ route('customer.bookings') }}" class="block px-4 py-2 text-sm text-charcoal-700 hover:bg-warm-50">My Bookings</a>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-charcoal-700 hover:bg-warm-50">Profile</a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-charcoal-700 hover:bg-warm-50">Admin Panel</a>
                                @endif
                                <hr class="my-1 border-charcoal-100">
                                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="block w-full text-left px-4 py-2 text-sm text-charcoal-700 hover:bg-warm-50">Log Out</button></form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-charcoal-600 hover:text-charcoal-900 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm">Book Now</a>
                    @endauth
                </div>
                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-charcoal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/><path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div x-show="mobileMenu" x-cloak class="md:hidden border-t border-charcoal-100 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Home</a>
                <a href="{{ route('rooms.index') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Rooms</a>
                <a href="{{ route('facilities.index') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Facilities</a>
                <a href="{{ route('gallery') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Gallery</a>
                @auth
                    <a href="{{ auth()->user()->isCustomer() ? route('customer.dashboard') : route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-sm text-charcoal-600 rounded hover:bg-warm-100">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success') || session('error') || session('warning'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-20 right-4 z-50 toast-enter">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg shadow-sm flex items-center gap-3 max-w-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    <p class="text-sm">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-sm flex items-center gap-3 max-w-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                    <p class="text-sm">{{ session('error') }}</p>
                    <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">&times;</button>
                </div>
            @endif
        </div>
    @endif

    <main>@yield('content')</main>

    <footer class="bg-charcoal-900 text-charcoal-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="font-display text-xl font-bold text-white">Stayora</span>
                        <span class="text-gold-500 font-display text-sm font-medium">Resort</span>
                    </div>
                    <p class="text-sm leading-relaxed text-charcoal-400 mb-6">A premium resort destination offering world-class accommodation, dining, and leisure experiences in a breathtaking natural setting.</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('rooms.index') }}" class="text-sm text-charcoal-400 hover:text-gold-500 transition-colors">Our Rooms</a></li>
                        <li><a href="{{ route('facilities.index') }}" class="text-sm text-charcoal-400 hover:text-gold-500 transition-colors">Facilities</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-sm text-charcoal-400 hover:text-gold-500 transition-colors">Gallery</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h4>
                    <ul class="space-y-3">
                        <li class="text-sm text-charcoal-400">Jl. Pantai Indah No. 88, Nusa Dua, Bali</li>
                        <li class="text-sm text-charcoal-400">+62 361 770 888</li>
                        <li class="text-sm text-charcoal-400">info@stayora.test</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Reception</h4>
                    <ul class="space-y-2">
                        <li class="text-sm text-charcoal-400">Check-in: 14:00</li>
                        <li class="text-sm text-charcoal-400">Check-out: 12:00</li>
                        <li class="text-sm text-charcoal-400">Front Desk: 24/7</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-charcoal-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <div>
                    <p class="text-xs text-charcoal-400">&copy; {{ date('Y') }} <strong>Stayora Resort Bali</strong>. All rights reserved.</p>
                    <p class="text-xs text-charcoal-500 mt-1">Luxury Resort & Hospitality System · Nusa Dua, Bali</p>
                </div>
                <div class="flex items-center gap-3.5 bg-charcoal-800/80 px-5 py-3 rounded-2xl border border-gold-500/30 shadow-lg">
                    <div class="w-9 h-9 rounded-xl bg-gold-500/20 border border-gold-500/40 flex items-center justify-center text-gold-400 font-bold text-sm font-display">
                        DA
                    </div>
                    <div class="text-left">
                        <span class="text-[10px] uppercase tracking-wider text-gold-400 font-bold block">Developer</span>
                        <span class="text-sm font-bold text-white tracking-wide">Daffa Ahmad Baihaqi</span>
                        <span class="text-[11px] text-charcoal-400 block">Stayora Hospitality Technologies</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
