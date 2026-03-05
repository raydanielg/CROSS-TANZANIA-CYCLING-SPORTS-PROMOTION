<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-950 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-slate-900 p-10 rounded-[2rem] border border-slate-800 shadow-2xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary shadow-lg shadow-primary/20 mb-6">
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-white uppercase">Admin Access</h2>
                <p class="mt-2 text-sm text-slate-400 uppercase tracking-widest font-medium">Mfumo wa Usimamizi</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('admin.login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-input-label for="email" value="Admin Email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-2xl bg-slate-800 border-slate-700 text-white focus:border-primary focus:ring-primary/20 placeholder-slate-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@crosstanzania.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div class="space-y-2 mt-4">
                    <x-input-label for="password" value="Security Key" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-2xl bg-slate-800 border-slate-700 text-white focus:border-primary focus:ring-primary/20"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/10 hover:bg-primary/90 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                        Unlock Dashboard
                    </button>
                </div>

                <div class="text-center">
                    <a href="/" class="text-xs text-slate-500 hover:text-white transition-colors font-medium">← Rudi kwenye Tovuti</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>