@extends('layouts.app')

@section('title', 'Notifications — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">Notifications</h1>
                <p class="text-xs text-charcoal-500 mt-1">Updates on your bookings, payments, and resort announcements.</p>
            </div>
            @if($notifications->isNotEmpty())
                <form action="{{ route('customer.notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-gold-700 hover:underline font-semibold">Mark all as read</button>
                </form>
            @endif
        </div>

        @if($notifications->isNotEmpty())
            <div class="bg-white rounded-xl border border-charcoal-200 shadow-sm divide-y divide-charcoal-100 overflow-hidden">
                @foreach($notifications as $notification)
                    <div class="p-5 flex items-start gap-4 {{ $notification->isRead() ? '' : 'bg-gold-50/40' }}">
                        <div class="w-8 h-8 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-charcoal-900">{{ $notification->title }}</h4>
                                <span class="text-[11px] text-charcoal-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-charcoal-600 mt-1 leading-relaxed">{{ $notification->message }}</p>
                        </div>
                        @if(!$notification->isRead())
                            <form action="{{ route('customer.notifications.read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[11px] text-gold-600 hover:text-gold-800 font-medium">Mark Read</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl p-12 text-center border border-charcoal-200 max-w-md mx-auto">
                <svg class="w-12 h-12 text-charcoal-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                <p class="text-xs text-charcoal-400">No notifications at this time.</p>
            </div>
        @endif
    </div>
</div>
@endsection
