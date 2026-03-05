@use('App\Models\Event')
@use('App\Models\Post')

<x-app-layout>
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-background pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="relative z-10 text-center md:text-left md:max-w-2xl animate-fade-in-up">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-foreground mb-6">
                    Gundua Uzuri wa <span class="text-primary">Tanzania</span> kwa Baiskeli
                </h1>
                <p class="text-lg md:text-xl text-muted-foreground mb-10 leading-relaxed">
                    Jiunge na jumuiya kubwa ya wapanda baiskeli Tanzania. Shiriki katika matukio, gundua njia mpya, na boresha afya yako.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-primary-foreground bg-primary rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/25">
                        Anza Sasa
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#events" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-foreground bg-secondary rounded-xl hover:bg-secondary/80 transition-all">
                        Matukio Yajayo
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative background element -->
        <div class="absolute top-0 right-0 -z-10 w-1/2 h-full hidden lg:block overflow-hidden">
             <div class="absolute inset-0 bg-gradient-to-l from-background to-transparent z-10"></div>
             <img src="https://images.unsplash.com/photo-1471506480208-8e93abc3b1ba?auto=format&fit=crop&q=80&w=2070" 
                  alt="Cycling in Tanzania" 
                  class="w-full h-full object-cover animate-float opacity-80">
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-secondary/30 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-1">50+</div>
                    <div class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Matukio</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-1">2,000+</div>
                    <div class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Wanachama</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-1">15+</div>
                    <div class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Mikoa</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-1">100%</div>
                    <div class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Furaha</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:gap-16">
                <div class="lg:w-1/2 mb-12 lg:mb-0 relative">
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1541625602330-2277a4c4b28d?auto=format&fit=crop&q=80&w=2070" 
                             alt="Cycling community" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-primary p-8 rounded-2xl shadow-xl hidden md:block">
                        <p class="text-primary-foreground font-black text-xl italic uppercase">Tunaendesha Pamoja!</p>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-primary font-bold uppercase tracking-widest text-sm mb-4">Kuhusu Sisi</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-foreground mb-6 leading-tight">
                        Cross Tanzania: Zaidi ya Kupanda Baiskeli
                    </h3>
                    <p class="text-muted-foreground text-lg mb-8 leading-relaxed">
                        Sisi ni jumuiya inayolenga kukuza mchezo wa baiskeli nchini Tanzania. Tunatengeneza matukio yanayounganisha watu, kukuza utalii wa ndani, na kuhamasisha mtindo wa maisha wenye afya.
                    </p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center text-foreground">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Matukio ya kila mwezi nchi nzima
                        </li>
                        <li class="flex items-center text-foreground">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Ushauri wa kiufundi na mafunzo
                        </li>
                        <li class="flex items-center text-foreground">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Mtandao wa wapanda baiskeli kitaifa
                        </li>
                    </ul>
                    <a href="#" class="text-primary font-bold hover:underline inline-flex items-center">
                        Soma zaidi kuhusu historia yetu
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events Section -->
    <section id="events" class="py-24 bg-secondary/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-primary font-bold uppercase tracking-widest text-sm mb-4">Matukio</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-foreground leading-tight">
                        Shiriki Katika Safari Ijayo
                    </h3>
                </div>
                <a href="#" class="inline-flex items-center px-6 py-3 border border-border rounded-xl text-foreground font-semibold hover:bg-background transition-colors">
                    Tazama Yote
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Example Event Card -->
                <div class="bg-card border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1471506480208-8e93abc3b1ba?auto=format&fit=crop&q=80&w=800" 
                             alt="Event" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-105">
                        <div class="absolute top-4 left-4 bg-primary text-primary-foreground px-3 py-1 rounded-lg font-bold text-sm">
                            25 Machi
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors">Arusha Cycling Tour</h4>
                        <p class="text-muted-foreground text-sm mb-4 line-clamp-2">Safari ya kitalii kuzunguka mji wa Arusha na vitongoji vyake.</p>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-sm font-semibold text-foreground">Arusha, TZ</span>
                            <a href="#" class="text-primary text-sm font-bold">Jiunge sasa →</a>
                        </div>
                    </div>
                </div>

                <div class="bg-card border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541625602330-2277a4c4b28d?auto=format&fit=crop&q=80&w=800" 
                             alt="Event" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-105">
                        <div class="absolute top-4 left-4 bg-primary text-primary-foreground px-3 py-1 rounded-lg font-bold text-sm">
                            12 Aprili
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors">Dar Night Ride</h4>
                        <p class="text-muted-foreground text-sm mb-4 line-clamp-2">Mzunguko wa usiku kutaarifu usalama barabarani kwa wapanda baiskeli.</p>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-sm font-semibold text-foreground">Dar es Salaam, TZ</span>
                            <a href="#" class="text-primary text-sm font-bold">Jiunge sasa →</a>
                        </div>
                    </div>
                </div>

                <div class="bg-card border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1471506480208-8e93abc3b1ba?auto=format&fit=crop&q=80&w=800" 
                             alt="Event" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-105">
                        <div class="absolute top-4 left-4 bg-primary text-primary-foreground px-3 py-1 rounded-lg font-bold text-sm">
                            05 Mei
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors">Dodoma Marathon</h4>
                        <p class="text-muted-foreground text-sm mb-4 line-clamp-2">Mashindano ya kasi kwa kategoria zote kuanzia watoto hadi wakongwe.</p>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-sm font-semibold text-foreground">Dodoma, TZ</span>
                            <a href="#" class="text-primary text-sm font-bold">Jiunge sasa →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary rounded-3xl p-12 text-center relative overflow-hidden shadow-2xl">
                <!-- Decorative pattern -->
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 L100 0 V100 H0 Z" fill="currentColor"></path>
                    </svg>
                </div>
                
                <h2 class="text-3xl md:text-5xl font-black text-primary-foreground mb-6 relative z-10">
                    Tayari Kwa Changamoto?
                </h2>
                <p class="text-primary-foreground/90 text-lg mb-10 max-w-2xl mx-auto relative z-10">
                    Jiunge na maelfu ya wapanda baiskeli leo na uanze safari yako ya kipekee nchini Tanzania. Usajili ni bure na rahisi.
                </p>
                <div class="flex flex-wrap justify-center gap-4 relative z-10">
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-background text-primary font-black rounded-xl hover:scale-105 transition-transform shadow-lg shadow-black/10">
                        Jisajili Sasa
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
