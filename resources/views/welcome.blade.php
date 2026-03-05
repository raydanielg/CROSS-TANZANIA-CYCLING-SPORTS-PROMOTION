<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cross Tanzania - Ultimate Cycling Experience</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981', // emerald-500
                        secondary: '#064e3b', // emerald-900
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.9) 0%, rgba(16, 185, 129, 0.8) 100%);
        }
        .scroll-smooth { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 scroll-smooth">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <i class="fas fa-bicycle text-primary text-3xl"></i>
                        <span class="text-2xl font-extrabold tracking-tight text-secondary uppercase">CROSS <span class="text-primary">TANZANIA</span></span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about" class="text-gray-600 hover:text-primary font-medium transition">About</a>
                    <a href="#events" class="text-gray-600 hover:text-primary font-medium transition">Events</a>
                    <a href="#sponsors" class="text-gray-600 hover:text-primary font-medium transition">Sponsors</a>
                    
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-primary text-white px-6 py-2.5 rounded-full font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-200">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary font-bold">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-2.5 rounded-full font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-200 text-sm">Join Now</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-primary focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden bg-secondary">
        <div class="absolute inset-0 z-0 opacity-40">
            <img src="https://images.unsplash.com/photo-1471506480208-8e93abc3b1ba?auto=format&fit=crop&q=80&w=2070" alt="Cycling Background" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 hero-gradient z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="text-center md:text-left max-w-3xl animate__animated animate__fadeInUp">
                <span class="inline-block px-4 py-1.5 mb-6 text-sm font-bold tracking-wider text-white uppercase bg-white/20 backdrop-blur-sm rounded-full">Explore Tanzania on Two Wheels</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                    Ride Through the <span class="text-emerald-300">Heart of Nature</span>
                </h1>
                <p class="text-xl text-emerald-50 mb-10 leading-relaxed">
                    Join the ultimate cycling challenge across the breathtaking landscapes of Tanzania. Connect with fellow riders, discover hidden gems, and push your limits.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-secondary font-extrabold rounded-xl hover:bg-emerald-50 transition transform hover:-translate-y-1 shadow-xl text-center">
                        Start Your Adventure
                    </a>
                    <a href="#events" class="px-8 py-4 bg-primary text-white font-extrabold rounded-xl hover:bg-emerald-600 transition transform hover:-translate-y-1 shadow-xl border border-emerald-400/30 text-center">
                        View Upcoming Events
                    </a>
                </div>
            </div>
        </div>

        <!-- Floating Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce hidden md:block">
            <a href="#about" class="text-white/70 hover:text-white transition">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- Features / Stats Section -->
    <section id="about" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl"></div>
                    <img src="https://images.unsplash.com/photo-1541625602330-2277a4c4b28d?auto=format&fit=crop&q=80&w=2070" alt="About Us" class="rounded-2xl shadow-2xl relative z-10">
                    <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl z-20 border border-emerald-50">
                        <div class="text-primary font-black text-4xl mb-1">10k+</div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-xs text-center">Riders</div>
                    </div>
                </div>
                
                <div class="animate__animated animate__fadeInRight">
                    <h2 class="text-primary font-extrabold uppercase tracking-widest text-sm mb-4">Why Cross Tanzania?</h2>
                    <h3 class="text-4xl font-extrabold text-secondary mb-6 leading-tight">Professional Cycling Events for Everyone</h3>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        We organize world-class cycling tours and competitions across Tanzania. From the majestic views of Mount Kilimanjaro to the pristine beaches of Zanzibar.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-shield-halved text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary text-sm">Safety First</h4>
                                <p class="text-gray-500 text-xs">Professional medical support and escort vehicles for every ride.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-trophy text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary text-sm">Professional Rankings</h4>
                                <p class="text-gray-500 text-xs">Track your progress and climb the leaderboard in our competitive races.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-emerald-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 border-b border-emerald-800/50 pb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <i class="fas fa-bicycle text-primary text-3xl"></i>
                        <span class="text-2xl font-black tracking-tight text-white uppercase">Cross <span class="text-primary">Tanzania</span></span>
                    </div>
                </div>
            </div>
            
            <div class="text-center text-emerald-100/50 text-xs">
                &copy; {{ date('Y') }} Cross Tanzania. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>