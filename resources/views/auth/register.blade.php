<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="font-display text-xl font-bold text-charcoal-900">Create Guest Account</h2>
        <p class="text-xs text-charcoal-500 mt-1">Join Stayora Resort for direct booking benefits and loyalty rewards.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label class="form-label" for="name">Full Name</label>
            <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label class="form-label" for="email">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label class="form-label" for="password">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button type="submit" class="w-full btn-primary py-2.5 justify-center shadow">
            Create Account
        </button>

        <div class="text-center pt-2">
            <p class="text-xs text-charcoal-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-gold-700 font-semibold hover:underline">Sign in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
