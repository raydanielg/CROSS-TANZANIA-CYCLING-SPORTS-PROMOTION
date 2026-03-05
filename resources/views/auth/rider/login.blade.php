<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-card p-10 rounded-[2rem] border border-border shadow-xl">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-2.5 mb-6 group">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-primary shadow-lg shadow-primary/20 transition-transform group-hover:scale-110">
                        <i class="fas fa-bicycle text-white text-xl"></i>
                    </div>
                </a>
                <h2 class="text-3xl font-bold tracking-tight text-foreground">Karibu Tena</h2>
                <p class="mt-2 text-sm text-muted-foreground">Ingia kwenye akaunti yako ya Rider</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-input-label for="email" value="Barua Pepe" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2 mt-4">
                    <x-input-label for="password" value="Nenosiri" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded-md border-border text-primary shadow-sm focus:ring-primary/20" name="remember">
                        <span class="ms-2 text-sm text-muted-foreground font-medium">Nikumbuke</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary hover:text-primary/80 font-bold" href="{{ route('password.request') }}">
                            Umesahau nenosiri?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-primary text-primary-foreground font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-1">
                        Ingia Sasa
                    </button>
                </div>

                <p class="text-center text-sm text-muted-foreground">
                    Huna akaunti? 
                    <a href="{{ route('register') }}" class="text-primary hover:text-primary/80 font-bold">Jisajili Hapa</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>