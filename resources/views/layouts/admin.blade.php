<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Stayora Resort</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-body text-charcoal-900 bg-warm-100 min-h-screen" x-data="{ sidebarOpen: true, mobileSidebar: false }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-charcoal-100 transition-all duration-300 transform lg:translate-x-0"
               :class="{ 'translate-x-0': mobileSidebar, '-translate-x-full': !mobileSidebar, 'lg:w-64': sidebarOpen, 'lg:w-20': !sidebarOpen, 'w-64': true }">
            {{-- Logo --}}
            <div class="flex items-center justify-between px-6 h-16 border-b border-charcoal-100">
                <div class="flex items-center gap-2">
                    <span class="font-display text-lg font-bold text-charcoal-900">Stayora</span>
                    <span class="text-gold-500 font-display text-xs font-medium" x-show="sidebarOpen">Resort</span>
                </div>
                {{-- Close Button for Mobile --}}
                <button @click="mobileSidebar = false" class="lg:hidden text-charcoal-500 hover:text-charcoal-800 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @php $role = auth()->user()->role; @endphp

                @if(in_array($role, ['admin', 'front_desk', 'finance']))
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                @endif

                @if(in_array($role, ['admin', 'front_desk']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">Reservations</p></div>
                <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span x-show="sidebarOpen">Bookings</span>
                </a>
                <a href="{{ route('admin.checkin.index') }}" class="sidebar-link {{ request()->routeIs('admin.checkin.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    <span x-show="sidebarOpen">Check-in</span>
                </a>
                <a href="{{ route('admin.checkout.index') }}" class="sidebar-link {{ request()->routeIs('admin.checkout.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                    <span x-show="sidebarOpen">Check-out</span>
                </a>
                @endif

                @if(in_array($role, ['admin', 'front_desk', 'housekeeping']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">Property</p></div>
                <a href="{{ route('admin.rooms.index') }}" class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0V8.25"/></svg>
                    <span x-show="sidebarOpen">Rooms</span>
                </a>
                @endif

                @if(in_array($role, ['admin']))
                <a href="{{ route('admin.room-types.index') }}" class="sidebar-link {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/></svg>
                    <span x-show="sidebarOpen">Room Types</span>
                </a>
                <a href="{{ route('admin.facilities.index') }}" class="sidebar-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                    <span x-show="sidebarOpen">Facilities</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                    <span x-show="sidebarOpen">Services</span>
                </a>
                @endif

                @if(in_array($role, ['admin', 'front_desk']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">Guests</p></div>
                <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    <span x-show="sidebarOpen">Customers</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                    <span x-show="sidebarOpen">Reviews</span>
                </a>
                @endif

                @if(in_array($role, ['admin']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">Marketing</p></div>
                <a href="{{ route('admin.promos.index') }}" class="sidebar-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6z"/></svg>
                    <span x-show="sidebarOpen">Promos</span>
                </a>
                @endif

                @if(in_array($role, ['admin', 'finance']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">Finance</p></div>
                <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    <span x-show="sidebarOpen">Payments</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    <span x-show="sidebarOpen">Reports</span>
                </a>
                @endif

                @if(in_array($role, ['admin']))
                <div class="pt-4"><p class="px-4 text-[10px] font-semibold text-charcoal-400 uppercase tracking-widest" x-show="sidebarOpen">System</p></div>
                <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen">Audit Logs</span>
                </a>
                @endif
            </nav>
            {{-- User Info & Developer Credit --}}
            <div class="border-t border-charcoal-100 p-3 space-y-2">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover">
                    <div x-show="sidebarOpen">
                        <p class="text-sm font-medium text-charcoal-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-charcoal-500 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                    </div>
                </div>
                <div x-show="sidebarOpen" class="bg-warm-50 p-2.5 rounded-lg border border-charcoal-100 text-center">
                    <span class="text-[9px] uppercase tracking-wider text-charcoal-400 font-bold block">Developer</span>
                    <span class="text-xs font-bold text-gold-700 block">Daffa Ahmad Baihaqi</span>
                    <span class="text-[10px] text-charcoal-500 block">System Engineering</span>
                </div>
            </div>
        </aside>

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebar" @click="mobileSidebar = false" x-cloak class="lg:hidden fixed inset-0 bg-black/30 z-40"></div>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header class="bg-white border-b border-charcoal-100 h-16 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebar = !mobileSidebar" class="lg:hidden text-charcoal-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>
                    <h1 class="text-lg font-semibold text-charcoal-900">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 bg-warm-50 px-3 py-1.5 rounded-full border border-gold-500/30 text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-charcoal-500">Crafted by</span>
                        <span class="font-bold text-gold-700">Daffa Ahmad Baihaqi</span>
                    </div>
                    <a href="{{ route('home') }}" class="text-xs text-charcoal-500 hover:text-charcoal-700 transition-colors" target="_blank">View Site →</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-charcoal-500 hover:text-charcoal-700 transition-colors">Log Out</button>
                    </form>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="p-4 lg:p-8">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <p class="text-sm">{{ session('success') }}</p>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <p class="text-sm">{{ session('error') }}</p>
                        <button @click="show = false" class="text-red-400 hover:text-red-600">&times;</button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
