<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-background">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-card shadow-sm border-b border-border">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-card border-t border-border py-12 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center gap-2 mb-4">
                                <x-application-logo class="block h-8 w-auto fill-current text-primary" />
                                <span class="text-lg font-black tracking-tighter text-foreground uppercase">CROSS <span class="text-primary">TANZANIA</span></span>
                            </div>
                            <p class="text-muted-foreground text-sm max-w-xs">
                                Tunajivunia kukuza utamaduni wa baiskeli nchini Tanzania. Jiunge nasi leo.
                            </p>
                        </div>
                        <div>
                            <h4 class="font-bold text-foreground mb-4">Viungo vya Haraka</h4>
                            <ul class="space-y-2 text-sm text-muted-foreground">
                                <li><a href="{{ url('/') }}" class="hover:text-primary transition-colors">Nyumbani</a></li>
                                <li><a href="#about" class="hover:text-primary transition-colors">Kuhusu Sisi</a></li>
                                <li><a href="#events" class="hover:text-primary transition-colors">Matukio</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-foreground mb-4">Wasiliana Nasi</h4>
                            <ul class="space-y-2 text-sm text-muted-foreground">
                                <li class="flex items-center gap-2"><i class="fas fa-envelope text-primary w-4"></i> info@crosstanzania.co.tz</li>
                                <li class="flex items-center gap-2"><i class="fas fa-phone text-primary w-4"></i> +255 700 000 000</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pt-8 border-t border-border text-center text-xs text-muted-foreground">
                        &copy; {{ date('Y') }} Cross Tanzania. Haki zote zimehifadhiwa.
                    </div>
                </div>
            </footer>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </body>
</html>
