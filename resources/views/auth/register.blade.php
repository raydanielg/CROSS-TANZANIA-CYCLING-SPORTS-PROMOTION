<x-auth-modern-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 text-center">Create account</h1>
        <p class="text-gray-500 mt-2 text-sm text-center">Join the cycling sports promotion platform.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-11 px-4 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-11 px-4 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-11 px-4 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:border-[#006837] focus:ring-[#006837] rounded-xl h-11 px-4 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-[#006837] hover:bg-[#00522c] text-white font-bold py-4 rounded-xl shadow-lg transition duration-150 ease-in-out transform hover:-translate-y-0.5 active:translate-y-0 uppercase tracking-widest text-xs">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                Already registered? 
                <a href="{{ route('login') }}" class="font-bold text-[#1D1D1B] hover:underline">Sign in</a>
            </p>
        </div>
    </form>
</x-auth-modern-layout>
