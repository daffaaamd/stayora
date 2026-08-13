<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="font-display text-xl font-bold text-charcoal-900">Sign in to your account</h2>
        <p class="text-xs text-charcoal-500 mt-1">Access your reservation portal or management dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="form-label" for="email">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <label class="form-label" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-gold-600 hover:text-gold-700 font-medium" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center text-xs text-charcoal-600 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-charcoal-300 text-gold-600 shadow-sm focus:ring-gold-500" name="remember">
                <span class="ms-2">Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full btn-primary py-2.5 justify-center shadow">
            Sign In
        </button>

        <div class="text-center pt-2">
            <p class="text-xs text-charcoal-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-gold-700 font-semibold hover:underline">Register here</a>
            </p>
        </div>
    </form>

    {{-- 1-Click Demo Accounts Switcher --}}
    <div class="mt-8 pt-6 border-t border-charcoal-100" x-data="{}">
        <span class="text-[10px] font-bold uppercase tracking-wider text-charcoal-400 block text-center mb-3">
            1-Click Demo Accounts (Password: <code class="text-gold-700">password</code>)
        </span>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <button type="button"
                    @click="document.getElementById('email').value = 'admin@stayora.test'; document.getElementById('password').value = 'password';"
                    class="p-2 rounded-lg bg-warm-100 hover:bg-gold-50 hover:border-gold-300 border border-charcoal-200 text-left transition-colors">
                <p class="font-bold text-charcoal-900">👑 Admin</p>
                <span class="text-[10px] text-charcoal-500">admin@stayora.test</span>
            </button>

            <button type="button"
                    @click="document.getElementById('email').value = 'frontdesk@stayora.test'; document.getElementById('password').value = 'password';"
                    class="p-2 rounded-lg bg-warm-100 hover:bg-gold-50 hover:border-gold-300 border border-charcoal-200 text-left transition-colors">
                <p class="font-bold text-charcoal-900">🛎️ Front Desk</p>
                <span class="text-[10px] text-charcoal-500">frontdesk@stayora.test</span>
            </button>

            <button type="button"
                    @click="document.getElementById('email').value = 'housekeeping@stayora.test'; document.getElementById('password').value = 'password';"
                    class="p-2 rounded-lg bg-warm-100 hover:bg-gold-50 hover:border-gold-300 border border-charcoal-200 text-left transition-colors">
                <p class="font-bold text-charcoal-900">🧹 Housekeeping</p>
                <span class="text-[10px] text-charcoal-500">housekeeping@stayora.test</span>
            </button>

            <button type="button"
                    @click="document.getElementById('email').value = 'finance@stayora.test'; document.getElementById('password').value = 'password';"
                    class="p-2 rounded-lg bg-warm-100 hover:bg-gold-50 hover:border-gold-300 border border-charcoal-200 text-left transition-colors">
                <p class="font-bold text-charcoal-900">💼 Finance</p>
                <span class="text-[10px] text-charcoal-500">finance@stayora.test</span>
            </button>

            <button type="button"
                    @click="document.getElementById('email').value = 'guest@stayora.test'; document.getElementById('password').value = 'password';"
                    class="p-2 rounded-lg bg-gold-50 hover:bg-gold-100 border border-gold-200 text-left transition-colors col-span-2">
                <p class="font-bold text-gold-900">🏖️ Customer / Guest</p>
                <span class="text-[10px] text-gold-700">guest@stayora.test</span>
            </button>
        </div>
    </div>
</x-guest-layout>
