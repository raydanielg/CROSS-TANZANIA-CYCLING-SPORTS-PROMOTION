<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-card p-10 rounded-[2rem] border border-border shadow-xl">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-2.5 mb-6 group">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-primary shadow-lg shadow-primary/20 transition-transform group-hover:scale-110">
                        <i class="fas fa-bicycle text-white text-xl"></i>
                    </div>
                </a>
                <h2 class="text-3xl font-bold tracking-tight text-foreground">Anza Safari Yako</h2>
                <p class="mt-2 text-sm text-muted-foreground">Jiunge na jumuiya kubwa ya Riders Tanzania</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Name -->
                <div class="space-y-2">
                    <x-input-label for="name" value="Jina Kamili" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="space-y-2 mt-4">
                    <x-input-label for="email" value="Barua Pepe" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2 mt-4">
                    <x-input-label for="password" value="Nenosiri" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2 mt-4">
                    <x-input-label for="password_confirmation" value="Thibitisha Nenosiri" class="text-xs font-bold uppercase tracking-widest text-muted-foreground" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-2xl bg-muted/50 border-border focus:border-primary focus:ring-primary/20"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-primary text-primary-foreground font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                        Tengeneza Akaunti
                    </button>
                </div>

                <p class="text-center text-sm text-muted-foreground">
                    Tayari unayo akaunti? 
                    <a href="{{ route('login') }}" class="text-primary hover:text-primary/80 font-bold">Ingia Hapa</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>