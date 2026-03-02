<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CROSS TANZANIA CYCLING SPORTS PROMOTION') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side: Login Form -->
            <div class="flex-1 flex items-center justify-center p-6 lg:p-12 bg-[#F3F4F6]">
                <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 lg:p-10">
                    <!-- Logo -->
                    <div class="mb-8 text-center lg:text-left">
                        <h2 class="text-3xl font-bold tracking-tighter italic text-[#006837]">
                            CROSS <span class="text-[#1D1D1B]">TANZANIA</span>
                        </h2>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mt-1">Cycling Sports Promotion</p>
                    </div>

                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
                        <p class="text-gray-500 mt-2 text-sm">Sign in to access your cycling sports account.</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>

            <!-- Right Side: Brand Image/Text -->
            <div class="hidden lg:flex flex-1 bg-[#006837] items-center justify-center p-12 text-white relative overflow-hidden">
                <div class="relative z-10 max-w-lg">
                    <p class="text-sm font-semibold tracking-widest uppercase mb-4 opacity-80">Cross Tanzania Platform</p>
                    <h2 class="text-5xl font-bold leading-tight mb-6">
                        Explore powerful cycling & sports networking.
                    </h2>
                    <p class="text-lg opacity-90 leading-relaxed mb-12">
                        Centralize your team registrations, partnerships, and cycling events in one modern platform. Designed for athletes, promoters, and sports professionals who care about performance, speed, and a great experience.
                    </p>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="font-bold text-xl mb-1 text-white">Global Network</p>
                            <p class="text-sm opacity-70">Connecting cyclists across Tanzania & beyond.</p>
                        </div>
                        <div>
                            <p class="font-bold text-xl mb-1 text-white">Trusted by Athletes</p>
                            <p class="text-sm opacity-70">Secure, professional, and optimized for results.</p>
                        </div>
                    </div>
                </div>

                <!-- Abstract decoration -->
                <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-black/10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </body>
</html>
