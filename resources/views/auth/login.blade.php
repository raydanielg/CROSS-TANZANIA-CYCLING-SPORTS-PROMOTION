<x-auth-modern-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-12 px-4 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-12 px-4 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#006837] shadow-sm focus:ring-[#006837]" name="remember">
                <span class="ms-2 text-sm text-gray-500">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-[#006837] hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#1D1D1B] hover:bg-black text-white font-bold py-4 rounded-xl shadow-lg transition duration-150 ease-in-out transform hover:-translate-y-0.5 active:translate-y-0 uppercase tracking-widest text-xs">
                {{ __('Sign in to your account') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-[#006837] hover:underline">Sign up</a>
            </p>
        </div>
    </form>
</x-auth-modern-layout>
