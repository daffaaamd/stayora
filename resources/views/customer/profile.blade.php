@extends('layouts.app')

@section('title', 'My Profile — Stayora Resort')

@section('content')
<div class="bg-warm-50 py-10 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="font-display text-2xl sm:text-3xl font-bold text-charcoal-900">Account Profile</h1>
            <p class="text-xs text-charcoal-500 mt-1">Manage your contact details and guest preferences.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 sm:p-10 border border-charcoal-200 shadow-sm space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-charcoal-100">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gold-200">
                <div>
                    <h2 class="font-display text-xl font-bold text-charcoal-900">{{ $user->name }}</h2>
                    <p class="text-xs text-charcoal-500">{{ $user->email }} · Member since {{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>

            <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Email Address (Read-only)</label>
                    <input type="email" value="{{ $user->email }}" disabled class="form-input bg-charcoal-50 text-charcoal-400 cursor-not-allowed">
                </div>

                <div>
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+62 812-3456-7890" class="form-input">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Residential Address</label>
                    <textarea name="address" rows="3" class="form-textarea" placeholder="City, Country">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary">Save Profile Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
