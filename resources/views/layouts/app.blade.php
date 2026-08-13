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
<body class="font-body text-charcoal-900 bg-white antialiased min-h-screen flex flex-col" x-data="{ mobileMenu: false }">
    {{-- Navigation --}}
    <nav class="bg-white/95 backdrop-blur-md border-b border-charcoal-100 sticky top-0 z-50 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 sm:h-20 items-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="font-display text-2xl font-bold text-charcoal-900 tracking-tight group-hover:text-gold-600 transition-colors">Stayora</span>
                    <span class="text-gold-500 font-display text-xs font-semibold uppercase tracking-widest px-2 py-0.5 bg-gold-50 rounded border border-gold-200">Resort</span>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-charcoal-600 hover:text-charcoal-900' }}">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('rooms.*') ? 'text-gold-600 font-semibold' : 'text-charcoal-600 hover:text-charcoal-900' }}">Rooms & Suites</a>
                    <a href="{{ route('facilities.index') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('facilities.*') ? 'text-gold-600 font-semibold' : 'text-charcoal-600 hover:text-charcoal-900' }}">Facilities</a>
                    <a href="{{ route('gallery') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('gallery') ? 'text-gold-600 font-semibold' : 'text-charcoal-600 hover:text-charcoal-900' }}">Gallery</a>
                </div>

                {{-- Desktop Auth & CTA --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        {{-- Notifications Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-full text-charcoal-500 hover:text-charcoal-900 hover:bg-warm-100 transition-colors relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">{{ min(auth()->user()->unreadNotifications()->count(), 9) }}</span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-charcoal-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-charcoal-100 flex items-center justify-between">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-charcoal-700">Notifications</h4>
                                    <a href="{{ route('customer.notifications') }}" class="text-[11px] text-gold-600 hover:underline">View all</a>
                                </div>
                                <div class="max-h-64 overflow-y-auto divide-y divide-charcoal-50">
                                    @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                        <div class="px-4 py-3 hover:bg-warm-50 transition-colors {{ $notification->isRead() ? '' : 'bg-gold-50/50' }}">
                                            <p class="text-xs font-semibold text-charcoal-900">{{ $notification->title }}</p>
                                            <p class="text-[11px] text-charcoal-500 mt-0.5">{{ Str::limit($notification->message, 60) }}</p>
                                            <p class="text-[10px] text-charcoal-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    @empty
                                        <p class="px-4 py-6 text-xs text-charcoal-400 text-center">No notifications yet</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-full hover:bg-warm-100 transition-colors border border-transparent hover:border-charcoal-200">
                                <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover border border-gold-300">
                                <span class="text-sm font-medium text-charcoal-800">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-charcoal-100 py-1.5 z-50">
                                <div class="px-4 py-2 border-b border-charcoal-100 mb-1">
                                    <p class="text-xs font-bold text-charcoal-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-charcoal-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-charcoal-700 hover:bg-gold-50 hover:text-gold-800">
                                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z"/></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('customer.bookings') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-charcoal-700 hover:bg-gold-50 hover:text-gold-800">
                                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                        My Bookings
                                    </a>
                                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-charcoal-700 hover:bg-gold-50 hover:text-gold-800">
                                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        My Profile
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-charcoal-700 hover:bg-gold-50 hover:text-gold-800">
                                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <hr class="my-1 border-charcoal-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-charcoal-700 hover:text-charcoal-900 transition-colors px-3 py-2">Sign In</a>
                        <a href="{{ route('rooms.index') }}" class="btn-primary btn-sm rounded-full shadow-md shadow-gold-500/20">Book Now</a>
                    @endauth
                </div>

                {{-- Mobile Hamburger Button --}}
                <div class="flex items-center gap-2 md:hidden">
                    @auth
                        <a href="{{ route('customer.notifications') }}" class="p-2 text-charcoal-600 hover:text-charcoal-900 relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </a>
                    @endauth
                    <button @click="mobileMenu = !mobileMenu" class="p-2.5 rounded-xl text-charcoal-700 hover:bg-warm-100 focus:outline-none transition-colors border border-charcoal-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Drawer Menu --}}
            <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden border-t border-charcoal-100 py-4 space-y-3 pb-6">
                {{-- Navigation Links --}}
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('home') ? 'bg-gold-50 text-gold-800 font-semibold' : 'text-charcoal-700 hover:bg-warm-50' }}">
                        <span>Home</span>
                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('rooms.index') }}" class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('rooms.*') ? 'bg-gold-50 text-gold-800 font-semibold' : 'text-charcoal-700 hover:bg-warm-50' }}">
                        <span>Rooms & Suites</span>
                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('facilities.index') }}" class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('facilities.*') ? 'bg-gold-50 text-gold-800 font-semibold' : 'text-charcoal-700 hover:bg-warm-50' }}">
                        <span>Resort Facilities</span>
                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('gallery') }}" class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('gallery') ? 'bg-gold-50 text-gold-800 font-semibold' : 'text-charcoal-700 hover:bg-warm-50' }}">
                        <span>Photo Gallery</span>
                        <svg class="w-4 h-4 text-charcoal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Mobile Auth Section --}}
                <div class="pt-3 border-t border-charcoal-100">
                    @auth
                        <div class="p-3 bg-warm-50 rounded-xl mb-3 border border-charcoal-100">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover border border-gold-400">
                                <div>
                                    <p class="text-sm font-bold text-charcoal-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-charcoal-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3 pt-2 border-t border-charcoal-200">
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ route('customer.dashboard') }}" class="text-center py-2 px-3 bg-white text-xs font-semibold text-charcoal-800 rounded-lg border border-charcoal-200 hover:border-gold-400 shadow-sm">Dashboard</a>
                                    <a href="{{ route('customer.bookings') }}" class="text-center py-2 px-3 bg-white text-xs font-semibold text-charcoal-800 rounded-lg border border-charcoal-200 hover:border-gold-400 shadow-sm">My Bookings</a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="col-span-2 text-center py-2 px-3 bg-gold-500 text-xs font-bold text-white rounded-lg shadow-sm">Admin Dashboard</a>
                                @endif
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center py-3 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">Log Out</button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <a href="{{ route('login') }}" class="w-full text-center py-3 text-sm font-semibold text-charcoal-800 bg-warm-100 hover:bg-warm-200 rounded-xl transition-colors">Sign In</a>
                            <a href="{{ route('rooms.index') }}" class="w-full text-center py-3 text-sm font-bold text-white bg-gold-500 hover:bg-gold-600 rounded-xl shadow-md transition-colors">Book Now</a>
                        </div>
                    @endauth
                </div>
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
