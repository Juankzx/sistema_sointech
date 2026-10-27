<div
    x-data="{
        mobileMenu: false,
        scrolled: false,
        activeSlide: 0,
        slides: [
            {
                tag: 'MAC & NOTEBOOKS',
                badge: 'MacBook · Windows · Gamer',
                title: 'Servicio Técnico Especializado de Computadores & Mac',
                desc: 'Mantención térmica profunda con pasta de alta conductividad, reemplazo de pantallas retina, bisagras y upgrades SSD NVMe para portátiles y MacBook Air / Pro.',
                img: '{{ asset('images/landing/notebooks.jpg') }}',
                link: '#servicios'
            },
            {
                tag: 'ELECTRÓNICA AVANZADA',
                badge: 'Cortos · IC Carga · Reballing',
                title: 'Microsoldadura SMD/BGA & Reparación de Placas',
                desc: 'Diagnosticamos a nivel componente con microscopio trinocular y termografía infrarroja para salvar la placa madre original de tu equipo sin sobrecostos.',
                img: '{{ asset('images/landing/microsoldering.jpg') }}',
                link: '#microsoldadura'
            },
            {
                tag: 'CONSOLAS DE VIDEOJUEGOS',
                badge: 'HDMI 2.1 · Metal Líquido · Drift',
                title: 'PlayStation 5, Xbox Series & Nintendo Switch',
                desc: 'Cambio de puerto HDMI 2.1 bajo microscopio, mantención térmica con Metal Líquido certificado y reparación de controles con drift Hall Effect.',
                img: '{{ asset('images/landing/consoles.jpg') }}',
                link: '#servicios'
            },
            {
                tag: 'MÓVILES & PANTALLAS OLED',
                badge: 'iPhone · Samsung · iPad',
                title: 'Servicio Técnico iPhone, Smartphones & Tablets',
                desc: 'Reemplazo de pantallas OLED de alta fidelidad, cambio de baterías certificadas, puertos USB-C/Lightning y tratamiento ultrasónico.',
                img: '{{ asset('images/landing/mobile.jpg') }}',
                link: '#servicios'
            },
            {
                tag: 'DIVISIÓN CORPORATIVA B2B',
                badge: 'Soporte Empresas · Redes · POS',
                title: 'Soluciones Informáticas & Soporte TI para Empresas',
                desc: 'Mantención preventiva de flotas de computadores, redes estructuradas Wi-Fi corporativas, servidores Cloud y desarrollo de software a medida.',
                img: '{{ asset('images/landing/b2b.jpg') }}',
                link: '#empresas'
            }
        ],
        init() {
            setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 6000);
            this.updateScroll();
        },
        activeSection: 'inicio',
        sections: ['inicio', 'rastreo', 'servicios', 'microsoldadura', 'empresas', 'instagram', 'contacto'],
        updateScroll() {
            const scrollY = window.pageYOffset || window.scrollY || document.documentElement.scrollTop || 0;
            this.scrolled = scrollY > 20;

            const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
            if ((window.innerHeight + scrollY) >= (scrollHeight - 160)) {
                this.activeSection = 'contacto';
                return;
            }

            for (let i = this.sections.length - 1; i >= 0; i--) {
                const el = document.getElementById(this.sections[i]);
                if (el) {
                    const rect = el.getBoundingClientRect();
                    if (rect.top <= 240) {
                        this.activeSection = this.sections[i];
                        return;
                    }
                }
            }
            this.activeSection = 'inicio';
        }
    }"
    @scroll.window="updateScroll()"
    class="min-h-screen bg-[#000000] text-neutral-100 font-sans selection:bg-neutral-800 selection:text-white relative antialiased"
>

    @php
        $whatsappNumber = '+56 9 4529 6314';
        $whatsappClean  = '56945296314';
        $whatsappUrl    = 'https://wa.me/56945296314?text=' . urlencode('Hola Soin Technology, necesito consultar por servicio técnico / soporte.');
        $igProfileUrl   = 'https://www.instagram.com/soin_tech';
    @endphp

    <!-- Apple Ambient Keynote Spotlight (Subtle & Refined, Zero Noise) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-[25%] left-1/2 -translate-x-1/2 w-[65rem] h-[35rem] rounded-full bg-gradient-to-b from-neutral-800/25 via-neutral-900/10 to-transparent blur-[120px]"></div>
        <div class="absolute top-[35%] right-[-10rem] w-[40rem] h-[40rem] rounded-full bg-neutral-900/20 blur-[140px]"></div>
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(rgba(255, 255, 255, 0.4) 1px, transparent 1px); background-size: 32px 32px;"></div>
    </div>

    <!-- FIXED TOP NAVIGATION WRAPPER (Guaranteed Never to Disappear on Scroll) -->
    <div class="fixed top-0 inset-x-0 w-full z-50 transition-all duration-300">

        <!-- Apple Global Ribbon (Smoothly collapses when scrolled) -->
        <div
            class="border-b bg-black/90 backdrop-blur-md text-[11px] text-neutral-400 transition-all duration-300"
            :class="scrolled ? 'max-h-0 opacity-0 overflow-hidden py-0 border-transparent pointer-events-none' : 'max-h-14 opacity-100 py-2 border-white/[0.06]'"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span class="text-neutral-300 font-medium">Laboratorio de Precisión &amp; Soporte TI Activo</span>
                    <span class="hidden sm:inline text-neutral-600">/</span>
                    <span class="hidden sm:inline text-neutral-400">Garantía escrita y seguimiento digital en tiempo real</span>
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-neutral-300 hover:text-white transition">
                        <svg class="w-3.5 h-3.5 text-neutral-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>@soin_tech</span>
                    </a>
                    <span class="text-neutral-700">|</span>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-neutral-300 hover:text-white transition">
                        <svg class="w-3.5 h-3.5 text-[#25D366] fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                        </svg>
                        <span>{{ $whatsappNumber }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Apple Frosted Glass Navbar with ScrollSpy Highlighting -->
        <header
            class="transition-all duration-300 border-b"
            :class="scrolled ? 'bg-black/90 backdrop-blur-2xl border-white/[0.1] shadow-[0_15px_40px_rgba(0,0,0,0.85)] py-2' : 'bg-black/75 backdrop-blur-xl border-white/[0.06] py-3'"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Brand Logo -->
                    <a href="#inicio" @click="activeSection = 'inicio'" class="flex items-center gap-3.5 group">
                        <div class="w-12 h-12 rounded-2xl bg-white/[0.06] border border-white/10 p-1 flex items-center justify-center shrink-0 overflow-hidden group-hover:border-white/30 group-hover:bg-white/[0.1] transition shadow-xs">
                            <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-300" alt="Soin Technology Logo">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg sm:text-xl tracking-tight text-white leading-none">
                                SOIN <span class="text-neutral-400 font-light">TECHNOLOGY</span>
                            </span>
                            <span class="text-[10px] sm:text-[11px] font-medium tracking-wider text-neutral-400 uppercase mt-1">
                                Laboratorio &amp; Soluciones TI
                            </span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links (with Active Section Highlight / ScrollSpy) -->
                    <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5 p-1 rounded-full bg-white/[0.03] border border-white/[0.08] backdrop-blur-md">
                        <a
                            href="#inicio"
                            @click="activeSection = 'inicio'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'inicio' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Inicio
                        </a>
                        <a
                            href="#rastreo"
                            @click="activeSection = 'rastreo'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'rastreo' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Seguimiento OT
                        </a>
                        <a
                            href="#servicios"
                            @click="activeSection = 'servicios'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'servicios' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Especialidades
                        </a>
                        <a
                            href="#microsoldadura"
                            @click="activeSection = 'microsoldadura'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'microsoldadura' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Microsoldadura
                        </a>
                        <a
                            href="#empresas"
                            @click="activeSection = 'empresas'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'empresas' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Empresas B2B
                        </a>
                        <a
                            href="#instagram"
                            @click="activeSection = 'instagram'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'instagram' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Instagram
                        </a>
                        <a
                            href="#contacto"
                            @click="activeSection = 'contacto'"
                            class="px-3.5 py-1.5 rounded-full text-xs transition-all duration-200 cursor-pointer"
                            :class="activeSection === 'contacto' ? 'bg-white text-black font-semibold shadow-xs' : 'text-neutral-400 hover:text-white hover:bg-white/[0.05] font-medium'"
                        >
                            Contacto
                        </a>
                    </nav>

                    <!-- Right CTAs -->
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="#contacto" @click="activeSection = 'contacto'" class="px-5 py-2 rounded-full text-xs font-semibold bg-white text-black hover:bg-neutral-200 transition shadow-xs">
                            Cotizar
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full text-xs font-medium bg-white/[0.08] hover:bg-white/[0.14] text-white border border-white/10 transition flex items-center gap-2">
                                <span>Panel</span>
                                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-xs font-medium bg-white/[0.06] hover:bg-white/[0.12] text-neutral-300 hover:text-white border border-white/10 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Acceso Taller</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" type="button" class="lg:hidden p-2 rounded-xl bg-white/[0.06] border border-white/10 text-neutral-300 hover:text-white cursor-pointer" aria-label="Abrir menú">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer with Highlighted Active Section -->
            <div x-show="mobileMenu" x-transition style="display: none;" class="lg:hidden border-t border-white/[0.08] bg-black/95 backdrop-blur-2xl px-5 pt-4 pb-6 space-y-1.5">
                <a
                    @click="mobileMenu = false; activeSection = 'inicio'"
                    href="#inicio"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'inicio' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Inicio</a>
                <a
                    @click="mobileMenu = false; activeSection = 'rastreo'"
                    href="#rastreo"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'rastreo' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Rastrear Orden OT</a>
                <a
                    @click="mobileMenu = false; activeSection = 'servicios'"
                    href="#servicios"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'servicios' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Especialidades Técnicas</a>
                <a
                    @click="mobileMenu = false; activeSection = 'microsoldadura'"
                    href="#microsoldadura"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'microsoldadura' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Microsoldadura &amp; Placas</a>
                <a
                    @click="mobileMenu = false; activeSection = 'empresas'"
                    href="#empresas"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'empresas' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Soporte TI para Empresas</a>
                <a
                    @click="mobileMenu = false; activeSection = 'instagram'"
                    href="#instagram"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'instagram' ? 'bg-white text-black font-semibold' : 'text-neutral-300 hover:bg-white/5 font-medium'"
                >Instagram Oficial</a>
                <a
                    @click="mobileMenu = false; activeSection = 'contacto'"
                    href="#contacto"
                    class="block px-3.5 py-2.5 rounded-xl text-sm transition"
                    :class="activeSection === 'contacto' ? 'bg-white text-black font-semibold' : 'text-white hover:bg-white/5 font-medium'"
                >Solicitar Presupuesto</a>

                <div class="pt-3 border-t border-white/[0.08] flex gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full text-center py-2.5 rounded-full text-xs font-semibold bg-white text-black">Ir al Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-full text-xs font-medium bg-white/[0.08] text-white border border-white/10">Acceso Taller</a>
                    @endauth
                </div>
            </div>
        </header>
    </div>

    <!-- ============================================================== -->
    <!-- HERO SECTION: APPLE KEYNOTE PRESENTATION                       -->
    <!-- ============================================================== -->
    <section id="inicio" class="relative z-10 pt-28 sm:pt-36 lg:pt-40 pb-16 lg:pb-24 overflow-hidden scroll-mt-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Grand Apple Headline -->
            <div class="text-center max-w-4xl mx-auto space-y-4 mb-12 sm:mb-16">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-medium uppercase tracking-[0.2em] bg-white/[0.05] border border-white/10 text-neutral-300">
                    Laboratorio Técnico de Alta Precisión
                </span>

                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white leading-[1.08]">
                    Ingeniería de precisión.<br>
                    <span class="bg-gradient-to-b from-white via-neutral-200 to-neutral-500 bg-clip-text text-transparent">
                        Para tus equipos más valiosos.
                    </span>
                </h1>

                <p class="text-base sm:text-lg text-neutral-400 max-w-2xl mx-auto font-normal leading-relaxed pt-1">
                    Especialistas en diagnóstico a nivel componente, microsoldadura y mantención avanzada para Mac, PC gamer, consolas y smartphones.
                </p>

                <!-- Apple CTAs -->
                <div class="pt-4 flex flex-wrap justify-center items-center gap-3.5">
                    <a href="#contacto" class="px-7 py-3 rounded-full text-sm font-medium bg-white text-black hover:bg-neutral-200 transition-all shadow-sm">
                        Solicitar Diagnóstico
                    </a>
                    <a href="#rastreo" class="px-6 py-3 rounded-full text-sm font-medium bg-white/[0.08] hover:bg-white/[0.14] text-white border border-white/10 backdrop-blur-md transition-all">
                        Rastrear Orden OT
                    </a>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3 rounded-full text-sm font-medium bg-[#25D366]/15 hover:bg-[#25D366] text-[#25D366] hover:text-black border border-[#25D366]/30 transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/></svg>
                        <span>WhatsApp Directo</span>
                    </a>
                </div>
            </div>

            <!-- Apple Cinematic Carousel Showcase -->
            <div class="relative rounded-3xl overflow-hidden border border-white/[0.1] bg-[#121214] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] max-w-6xl mx-auto">
                <div class="relative min-h-[440px] sm:min-h-[520px] flex flex-col justify-end p-6 sm:p-10 lg:p-12">

                    <!-- Background Crossfading Photography -->
                    <template x-for="(slide, index) in slides" :key="index">
                        <div
                            x-show="activeSlide === index"
                            x-transition:enter="transition-all duration-700 ease-out"
                            x-transition:enter-start="opacity-0 scale-102"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition-all duration-500 ease-in"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-98"
                            class="absolute inset-0 z-0"
                        >
                            <img :src="slide.img" :alt="slide.title" class="w-full h-full object-cover">
                            <!-- Deep Studio Vignette -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/20"></div>
                        </div>
                    </template>

                    <!-- Active Slide Content Overlay -->
                    <div class="relative z-10 max-w-2xl space-y-3">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-semibold tracking-wider uppercase bg-white/10 backdrop-blur-md text-white border border-white/15" x-text="slides[activeSlide].tag"></span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-white/[0.06] text-neutral-300 border border-white/10" x-text="slides[activeSlide].badge"></span>
                        </div>

                        <h2 class="text-2xl sm:text-4xl font-bold text-white tracking-tight leading-snug" x-text="slides[activeSlide].title"></h2>
                        <p class="text-xs sm:text-sm text-neutral-300 font-normal leading-relaxed" x-text="slides[activeSlide].desc"></p>

                        <!-- Apple Slider Controls -->
                        <div class="pt-4 flex items-center justify-between border-t border-white/10">
                            <a :href="slides[activeSlide].link" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                                <span>Conocer detalles</span>
                                <span>→</span>
                            </a>

                            <!-- Minimalist Indicator Pills -->
                            <div class="flex items-center gap-1.5">
                                <template x-for="(slide, index) in slides" :key="'dot-'+index">
                                    <button
                                        @click="activeSlide = index"
                                        type="button"
                                        class="h-1 rounded-full transition-all duration-300 cursor-pointer"
                                        :class="activeSlide === index ? 'w-6 bg-white' : 'w-2 bg-white/30 hover:bg-white/60'"
                                        :title="slide.tag"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- RASTREO DE ORDEN OT: APPLE "FIND MY / STATUS" PORTAL           -->
    <!-- ============================================================== -->
    <section id="rastreo" class="relative z-10 py-16 sm:py-20 border-t border-white/[0.06] bg-[#08080a] scroll-mt-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-[#121214] border border-white/10 p-7 sm:p-10 shadow-2xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/[0.08] pb-6">
                    <div>
                        <span class="text-[11px] font-semibold tracking-widest uppercase text-neutral-400 block">
                            Portal Digital de Clientes
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight mt-1">
                            Consulta el Estado de tu Equipo
                        </h2>
                        <p class="text-xs sm:text-sm text-neutral-400 mt-1">
                            Transparencia total: fotografías de ingreso, bitácora de diagnóstico y presupuesto en línea.
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/[0.05] border border-white/10 text-xs text-neutral-300 self-start sm:self-auto">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Sincronización en vivo</span>
                    </div>
                </div>

                <!-- 4-Step Minimal Timeline -->
                <div class="grid grid-cols-4 gap-2 text-center py-2">
                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                        <span class="text-xs font-semibold text-white block">1. Ingreso</span>
                        <span class="text-[10px] text-neutral-500 block mt-0.5">Check-in digital</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                        <span class="text-xs font-semibold text-white block">2. Revisión</span>
                        <span class="text-[10px] text-neutral-500 block mt-0.5">Diagnóstico técnico</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                        <span class="text-xs font-semibold text-white block">3. Taller</span>
                        <span class="text-[10px] text-neutral-500 block mt-0.5">Reparación activa</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                        <span class="text-xs font-semibold text-emerald-400 block">4. Listo</span>
                        <span class="text-[10px] text-neutral-500 block mt-0.5">Entrega &amp; Garantía</span>
                    </div>
                </div>

                <!-- Search Input Form -->
                <form wire:submit="searchOrder" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-neutral-300 mb-2">
                            Ingresa tu N° de Orden (OT), RUT o Teléfono de contacto
                        </label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input
                                wire:model="searchQuery"
                                type="text"
                                placeholder="Ej: OT-0012 o 12.345.678-9"
                                class="flex-1 px-4 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white placeholder-neutral-500 focus:outline-none focus:border-white/30 text-sm"
                            >
                            <button
                                type="submit"
                                class="px-6 py-3 rounded-xl font-medium text-sm text-black bg-white hover:bg-neutral-200 transition shrink-0 flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span wire:loading.remove wire:target="searchOrder">Buscar Orden</span>
                                <span wire:loading wire:target="searchOrder">Consultando...</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>

                        @if($searchError)
                            <div class="mt-3 p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-300 text-xs font-medium flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $searchError }}</span>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- BENTO GRID: ESPECIALIDADES TÉCNICAS (#servicios)               -->
    <!-- ============================================================== -->
    <section id="servicios" class="relative z-10 py-20 sm:py-28 border-t border-white/[0.06] bg-[#000000] scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mb-16">
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400 block mb-2">
                    Especialidades del Laboratorio
                </span>
                <h2 class="text-3xl sm:text-5xl font-bold text-white tracking-tight">
                    Rendimiento y precisión en cada área técnica.
                </h2>
                <p class="text-neutral-400 text-base sm:text-lg mt-3 leading-relaxed">
                    Atención dedicada para usuarios exigentes, profesionales creativos, gamers y pequeñas/medianas empresas.
                </p>
            </div>

            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">

                <!-- 1. Computadores, Notebooks & Mac -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/notebooks.jpg') }}" alt="Servicio Técnico Notebooks y Mac" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                Mac &amp; PC
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Computadores, Notebooks &amp; Mac
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Optimización profunda, pasta térmica de alta conductividad, pantallas retina, teclados, bisagras y upgrades NVMe de alto rendimiento.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Mantención Térmica</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Upgrade SSD NVMe &amp; RAM</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">MacBook Air &amp; Pro</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Solicitar presupuesto para Notebook / Mac</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Celulares, iPhone & Tablets -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/mobile.jpg') }}" alt="Servicio Técnico iPhone y Celulares" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                Dispositivos Móviles
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                iPhone, Smartphones &amp; Tablets
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Instalación de pantallas OLED con calibración de color, cambio de baterías certificadas, puertos USB-C/Lightning y rescate ultrasónico.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Pantallas OLED</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Baterías de Calidad</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Sellado Antihumedad</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Celular / iPhone / Tablet')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Solicitar presupuesto para Móviles</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Consolas de Videojuegos -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/consoles.jpg') }}" alt="Servicio Técnico Consolas PS5 Xbox Switch" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                Gaming &amp; Consolas
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                PlayStation 5, Xbox &amp; Switch
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Reemplazo de puerto HDMI 2.1 bajo microscopio, mantención térmica con Metal Líquido original y sustitución de análogos con drift.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Puerto HDMI 2.1</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Metal Líquido PS5</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Reparación Drift Mandos</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Consola (PS5 / Xbox / Switch)')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Solicitar presupuesto para Consola</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Microsoldadura & Placas Madre -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/microsoldering.jpg') }}" alt="Microsoldadura y Reparación de Placas Madre" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                Nivel Componente
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Microsoldadura SMD &amp; Placas Madre
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Localización de cortocircuitos con cámara térmica infrarroja y microscopía trinocular. Salvamos la placa original de tu computador o consola.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Cámara Térmica IR</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Reballing &amp; Chips SMD</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Programación BIOS</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Microsoldadura / Reparación de Placa Madre')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Recuperar Placa Madre</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 5. Armado de PC & Rescate de Datos -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/workstation.jpg') }}" alt="Armado de PC Gaming y Rescate de Datos" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                Workstations &amp; Almacenamiento
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Workstations, GPUs &amp; Rescate de Datos
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Ensamblaje de estaciones de trabajo para renderizado o gaming, mantención de GPUs y recuperación segura de información en discos dañados.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Armado Pro Clean</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Thermal Pads GPU</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Recuperación de Archivos</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Cotizar PC / Rescate de Datos</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Soluciones TI para Empresas (B2B) -->
                <div class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-black">
                            <img src="{{ asset('images/landing/b2b.jpg') }}" alt="Soluciones Informáticas Empresas B2B" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-medium tracking-wider uppercase bg-black/75 backdrop-blur-md text-white border border-white/10">
                                División B2B
                            </span>
                        </div>

                        <div class="p-7">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Soluciones TI &amp; Redes para Empresas
                            </h3>
                            <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                                Tu departamento informático externo: convenios preventivos de flotas, redes estructuradas Wi-Fi, servidores y software de gestión a medida.
                            </p>

                            <div class="flex flex-wrap gap-1.5 mt-5 pt-4 border-t border-white/[0.08]">
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Convenios de Flotas</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Redes Corporativas</span>
                                <span class="px-2.5 py-1 rounded-md bg-white/[0.04] text-[11px] text-neutral-300">Sistemas POS &amp; Web</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-7 pb-7">
                        <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="text-xs font-medium text-white hover:text-neutral-300 inline-flex items-center gap-1.5 transition">
                            <span>Solicitar propuesta empresarial</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- MICROSOLDADURA: APPLE HARDWARE ENGINEERING LAB                 -->
    <!-- ============================================================== -->
    <section id="microsoldadura" class="relative z-10 py-20 sm:py-28 border-t border-white/[0.06] bg-[#08080a] scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <!-- Left Lab Image Showcase -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                        <img
                            src="{{ asset('images/landing/microsoldering.jpg') }}"
                            alt="Laboratorio de Microsoldadura Soin Technology"
                            class="w-full h-[400px] sm:h-[480px] object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 p-5 rounded-2xl bg-black/85 backdrop-blur-xl border border-white/10">
                            <span class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 block">Diagnóstico no invasivo</span>
                            <p class="text-sm font-medium text-white mt-1">Identificamos el componente exacto con falla en lugar de cambiar la placa completa.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Lab Technical Specs -->
                <div class="lg:col-span-6 space-y-7">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400 block mb-2">
                            Tecnología de Laboratorio
                        </span>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                            Precisión quirúrgica en circuitos impresos.
                        </h2>
                        <p class="text-neutral-400 text-sm sm:text-base mt-3 leading-relaxed">
                            Contamos con equipamiento de nivel industrial para localizar fallas microscópicas provocadas por alzas de voltaje, desgaste o derrames de líquidos.
                        </p>
                    </div>

                    <!-- 4 Clean Technical Modules -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-5 rounded-2xl bg-[#121214] border border-white/10 space-y-1.5">
                            <div class="text-xs font-semibold text-white tracking-tight">Microscopía Óptica HD</div>
                            <p class="text-xs text-neutral-400 leading-relaxed">Reconstrucción de pistas internas, soldadura de circuitos integrados BGA y conectores FPC.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-[#121214] border border-white/10 space-y-1.5">
                            <div class="text-xs font-semibold text-white tracking-tight">Termografía Infrarroja</div>
                            <p class="text-xs text-neutral-400 leading-relaxed">Mapeo térmico inmediato que revela condensadores en corto y fugas parasitarias de corriente.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-[#121214] border border-white/10 space-y-1.5">
                            <div class="text-xs font-semibold text-white tracking-tight">Planos Esquemáticos</div>
                            <p class="text-xs text-neutral-400 leading-relaxed">Seguimiento de voltajes y señales según diagramas técnicos de fábrica y Boardview.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-[#121214] border border-white/10 space-y-1.5">
                            <div class="text-xs font-semibold text-white tracking-tight">Garantía por Escrito</div>
                            <p class="text-xs text-neutral-400 leading-relaxed">Pruebas de estrés térmico continuo antes de autorizar la entrega de tu equipo.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- EMPRESAS & SOPORTE TI B2B: APPLE AT WORK                       -->
    <!-- ============================================================== -->
    <section id="empresas" class="relative z-10 py-20 sm:py-28 border-t border-white/[0.06] bg-[#000000] scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-[#121214] border border-white/10 overflow-hidden shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center">

                    <div class="lg:col-span-7 p-8 sm:p-12 lg:p-14 space-y-6">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400 block">
                            Soluciones Corporativas B2B
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight leading-tight">
                            Continuidad operativa y soporte TI para tu negocio.
                        </h2>
                        <p class="text-sm sm:text-base text-neutral-400 leading-relaxed">
                            Aseguramos que la infraestructura tecnológica de tu empresa funcione sin interrupciones, desde la flota de portátiles hasta la red y los sistemas de punto de venta.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-2">
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="text-xs font-semibold text-white">Flotas de PCs</div>
                                <p class="text-[11px] text-neutral-400 mt-1">Mantenimiento programado y respuesta rápida ante incidencias.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="text-xs font-semibold text-white">Redes &amp; Wi-Fi</div>
                                <p class="text-[11px] text-neutral-400 mt-1">Conectividad estable, routers empresariales y respaldo seguro.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="text-xs font-semibold text-white">Software a Medida</div>
                                <p class="text-[11px] text-neutral-400 mt-1">Sistemas web de inventario, ventas POS y plataformas cloud.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="px-6 py-3 rounded-full text-xs font-medium bg-white text-black hover:bg-neutral-200 transition inline-block">
                                Coordinar Reunión Empresa →
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5 relative h-72 lg:h-full min-h-[360px] bg-black">
                        <img src="{{ asset('images/landing/b2b.jpg') }}" alt="Soporte Informático Empresas" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#121214] via-transparent to-transparent hidden lg:block"></div>
                        <div class="absolute bottom-5 right-5 px-4 py-2 rounded-full bg-black/80 backdrop-blur-md border border-white/10 text-xs font-medium text-neutral-200">
                            Facturación Electrónica &amp; SLA
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- INSTAGRAM GALLERY: APPLE "SHOT ON LAB" GRID (#instagram)       -->
    <!-- ============================================================== -->
    <section id="instagram" class="relative z-10 py-20 sm:py-28 border-t border-white/[0.06] bg-[#08080a] scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400 block mb-2">
                        Evidencia &amp; Trabajo Real
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">
                        Casos del Laboratorio en Instagram
                    </h2>
                    <p class="text-neutral-400 text-sm mt-1">
                        Publicamos diariamente el proceso de reparación de equipos de clientes: antes, durante y después.
                    </p>
                </div>

                <a
                    href="{{ $igProfileUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="shrink-0 px-5 py-2.5 rounded-full text-xs font-medium bg-white/[0.08] hover:bg-white/[0.14] text-white border border-white/10 transition inline-flex items-center gap-2"
                >
                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    <span>Seguir @soin_tech</span>
                </a>
            </div>

            <!-- Minimalist Photo Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $defaultImages = [
                        '/images/landing/microsoldering.jpg',
                        '/images/landing/consoles.jpg',
                        '/images/landing/notebooks.jpg',
                        '/images/landing/mobile.jpg',
                        '/images/landing/b2b.jpg',
                        '/images/landing/workstation.jpg',
                    ];
                @endphp
                @foreach($instagramPosts as $idx => $post)
                    @php
                        $postUrl = !empty($post['url']) ? $post['url'] : $igProfileUrl;
                        $photoSrc = !empty($post['image'])
                            ? Storage::url($post['image'])
                            : asset($post['asset_image'] ?? $defaultImages[$idx % count($defaultImages)]);
                    @endphp

                    <article class="group rounded-3xl bg-[#121214] border border-white/10 hover:border-white/25 overflow-hidden flex flex-col justify-between transition-all duration-300">
                        <div>
                            <!-- Header Info -->
                            <div class="px-5 py-3.5 flex items-center justify-between border-b border-white/[0.06]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-white/10 p-0.5 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Soin">
                                    </div>
                                    <span class="text-xs font-semibold text-white">soin_tech</span>
                                </div>
                                <span class="text-[10px] text-neutral-400 font-medium">
                                    {{ $post['category'] ?? 'Laboratorio' }}
                                </span>
                            </div>

                            <!-- Photography -->
                            <a href="{{ $postUrl }}" target="_blank" rel="noopener noreferrer" class="block relative h-64 overflow-hidden bg-black">
                                <img src="{{ $photoSrc }}" alt="{{ $post['title'] ?? 'Caso Técnico Soin Technology' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-transparent to-transparent opacity-80"></div>
                                <div class="absolute bottom-3 left-4 right-4">
                                    <h3 class="text-sm font-semibold text-white leading-snug">
                                        {{ $post['title'] ?? 'Caso de Laboratorio' }}
                                    </h3>
                                </div>
                            </a>

                            <!-- Caption -->
                            <div class="px-5 py-4">
                                <p class="text-xs text-neutral-400 leading-relaxed line-clamp-2">
                                    {{ $post['caption'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-3 border-t border-white/[0.06] flex items-center justify-between text-xs text-neutral-400">
                            <span class="inline-flex items-center gap-1.5 text-neutral-300">
                                <svg class="w-3.5 h-3.5 text-neutral-400 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                <span>{{ $post['likes'] ?? '150' }}</span>
                            </span>
                            <a href="{{ $postUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">
                                Ver en Instagram ↗
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ============================================================== -->
    <!-- CONTACTO & COTIZACIÓN DIRECTA (#contacto)                      -->
    <!-- ============================================================== -->
    <section id="contacto" class="relative z-10 py-20 sm:py-28 border-t border-white/[0.06] bg-[#000000] scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                <!-- Left Column Details -->
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-400 block mb-2">
                            Atención Inmediata
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-bold text-white tracking-tight">
                            Hablemos de tu equipo.
                        </h2>
                        <p class="text-neutral-400 text-sm sm:text-base mt-3 leading-relaxed">
                            Respuesta directa de nuestro equipo de laboratorio. Puedes escribirnos por WhatsApp o enviar tu solicitud para recibir un presupuesto orientativo.
                        </p>
                    </div>

                    <!-- Direct Channel Cards -->
                    <div class="space-y-3 pt-2">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-4 rounded-2xl bg-[#121214] border border-white/10 hover:border-white/25 transition group">
                            <div class="w-12 h-12 rounded-xl bg-[#25D366]/15 border border-[#25D366]/30 flex items-center justify-center text-[#25D366] shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold tracking-wider uppercase text-neutral-400 block">WhatsApp Oficial</span>
                                <span class="text-sm font-semibold text-white">{{ $whatsappNumber }}</span>
                            </div>
                        </a>

                        <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-4 rounded-2xl bg-[#121214] border border-white/10 hover:border-white/25 transition group">
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-neutral-300 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold tracking-wider uppercase text-neutral-400 block">Instagram</span>
                                <span class="text-sm font-semibold text-white">@soin_tech</span>
                            </div>
                        </a>

                        @if($settings && $settings->company_email)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#121214] border border-white/10">
                                <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-neutral-300 shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-semibold tracking-wider uppercase text-neutral-400 block">Correo Electrónico</span>
                                    <span class="text-sm font-semibold text-white">{{ $settings->company_email }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Form Column -->
                <div class="lg:col-span-7">
                    <div class="rounded-3xl bg-[#121214] border border-white/10 p-7 sm:p-10 shadow-2xl">
                        @if($quoteSubmitted)
                            <div class="py-12 text-center space-y-4">
                                <div class="w-14 h-14 rounded-full bg-white/10 text-white flex items-center justify-center mx-auto">
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white tracking-tight">Solicitud Recibida</h3>
                                <p class="text-sm text-neutral-400 max-w-md mx-auto">
                                    Un especialista del laboratorio revisará los detalles y te responderá a la brevedad.
                                </p>
                                <div class="pt-2 flex justify-center gap-3">
                                    <button wire:click="$set('quoteSubmitted', false)" type="button" class="px-5 py-2.5 rounded-full bg-white/10 text-xs font-medium text-white hover:bg-white/15 transition cursor-pointer">
                                        Enviar otra consulta
                                    </button>
                                </div>
                            </div>
                        @else
                            <form wire:submit="sendQuoteRequest" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-300 mb-1.5">Nombre o Empresa *</label>
                                        <input wire:model="contact_name" type="text" placeholder="Tu nombre" class="w-full px-4 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white placeholder-neutral-500 text-sm focus:outline-none focus:border-white/30">
                                        @error('contact_name') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-300 mb-1.5">Teléfono / WhatsApp *</label>
                                        <input wire:model="contact_phone" type="text" placeholder="+56 9 1234 5678" class="w-full px-4 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white placeholder-neutral-500 text-sm focus:outline-none focus:border-white/30">
                                        @error('contact_phone') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-300 mb-1.5">Correo (Opcional)</label>
                                        <input wire:model="contact_email" type="email" placeholder="correo@ejemplo.cl" class="w-full px-4 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white placeholder-neutral-500 text-sm focus:outline-none focus:border-white/30">
                                        @error('contact_email') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-300 mb-1.5">Categoría *</label>
                                        <select wire:model="device_type" class="w-full px-4 py-3 rounded-xl bg-[#18181b] border border-white/10 text-white text-sm focus:outline-none focus:border-white/30">
                                            <option value="">Selecciona una opción...</option>
                                            <option value="Servicio Técnico Computador / Notebook / Mac">Computador / Notebook / Mac</option>
                                            <option value="Servicio Técnico Celular / iPhone / Tablet">Celular / iPhone / Tablet</option>
                                            <option value="Servicio Técnico Consola (PS5 / Xbox / Switch)">Consola (PS5 / Xbox / Switch)</option>
                                            <option value="Microsoldadura / Reparación de Placa Madre">Microsoldadura / Placa Madre</option>
                                            <option value="Soluciones Informáticas / Soporte para Empresas">Soporte Empresas B2B</option>
                                            <option value="Desarrollo de Software / Sistema POS / Web">Software / POS / Desarrollo Web</option>
                                        </select>
                                        @error('device_type') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-neutral-300 mb-1.5">Detalle del equipo o requerimiento *</label>
                                    <textarea wire:model="issue_description" rows="3" placeholder="Describe la falla o el servicio que necesitas..." class="w-full px-4 py-3 rounded-xl bg-white/[0.05] border border-white/10 text-white placeholder-neutral-500 text-sm focus:outline-none focus:border-white/30"></textarea>
                                    @error('issue_description') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="w-full py-3.5 px-6 rounded-full font-medium text-sm text-black bg-white hover:bg-neutral-200 transition cursor-pointer">
                                    Enviar Consulta al Laboratorio
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Floating Clean WhatsApp Pill -->
    <a
        href="{{ $whatsappUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        title="WhatsApp Directo"
        class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-3 rounded-full bg-[#25D366] text-black font-semibold text-xs tracking-wide shadow-2xl hover:scale-105 transition-all"
    >
        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
        </svg>
        <span class="hidden sm:inline">WhatsApp</span>
    </a>

    <!-- ============================================================== -->
    <!-- FOOTER: APPLE DIRECTORY STRUCTURE                              -->
    <!-- ============================================================== -->
    <footer class="relative z-10 border-t border-white/[0.08] bg-[#050507] pt-16 pb-12 text-xs text-neutral-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Pre-Footer: Apple Quality & Trust Pillars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pb-14 border-b border-white/[0.08]">
                <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/[0.06] border border-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-5 h-5 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white tracking-wide">Laboratorio de Precisión</h4>
                        <p class="text-[11px] text-neutral-400 mt-1 leading-relaxed">
                            Microscopía trinocular y diagnóstico térmico para rescate de placas a nivel componente.
                        </p>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/[0.06] border border-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-5 h-5 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white tracking-wide">Garantía Escrita Formal</h4>
                        <p class="text-[11px] text-neutral-400 mt-1 leading-relaxed">
                            Respaldo técnico documentado en cada intervención de hardware y mantención térmica.
                        </p>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/[0.06] border border-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-5 h-5 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white tracking-wide">Privacidad de Datos</h4>
                        <p class="text-[11px] text-neutral-400 mt-1 leading-relaxed">
                            Protocolo estricto de confidencialidad para almacenamiento personal y corporativo.
                        </p>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/[0.06] border border-white/10 flex items-center justify-center shrink-0 text-white">
                        <svg class="w-5 h-5 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white tracking-wide">Continuidad TI Empresas</h4>
                        <p class="text-[11px] text-neutral-400 mt-1 leading-relaxed">
                            Soporte B2B, convenios de flotas y facturación electrónica con orden de compra.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Directory Structure -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 py-12 border-b border-white/[0.08]">

                <!-- Col 1: Brand & Identity (Lg: col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="#inicio" class="flex items-center gap-3.5 group">
                        <div class="w-14 h-14 rounded-2xl bg-white/[0.06] border border-white/10 p-1 flex items-center justify-center shrink-0 overflow-hidden group-hover:border-white/30 group-hover:bg-white/[0.1] transition shadow-xs">
                            <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-300" alt="Soin Technology Logo">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg sm:text-xl text-white tracking-tight leading-none">
                                SOIN <span class="text-neutral-400 font-light">TECHNOLOGY</span>
                            </span>
                            <span class="text-[10px] sm:text-[11px] font-medium tracking-wider text-neutral-400 uppercase mt-1">
                                Laboratorio Electrónico &amp; Soluciones TI
                            </span>
                        </div>
                    </a>

                    <p class="text-xs text-neutral-400 leading-relaxed max-w-sm">
                        Laboratorio especializado en ingeniería de reparación a nivel componente, microsoldadura avanzada SMD/BGA y continuidad operativa TI para usuarios exigentes y empresas en todo Chile.
                    </p>

                    <!-- Live Lab Status Pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[11px] text-emerald-400 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Laboratorio Activo · Recepción en Taller y Terreno</span>
                    </div>

                    <!-- Direct Chat & Social Shortcuts -->
                    <div class="flex flex-wrap items-center gap-2.5 pt-1">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] hover:bg-[#25D366]/10 border border-white/10 hover:border-[#25D366]/40 text-neutral-300 hover:text-white transition text-xs font-medium">
                            <svg class="w-3.5 h-3.5 text-[#25D366] fill-current" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                            </svg>
                            <span>{{ $whatsappNumber }}</span>
                        </a>

                        <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] hover:bg-pink-500/10 border border-white/10 hover:border-pink-500/30 text-neutral-300 hover:text-white transition text-xs font-medium">
                            <svg class="w-3.5 h-3.5 text-pink-400 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <span>@soin_tech</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Servicios Técnicos (Lg: col-span-3) -->
                <div class="lg:col-span-3 space-y-3">
                    <div class="text-xs font-semibold uppercase tracking-wider text-white">Servicios Técnicos</div>
                    <ul class="space-y-2 text-neutral-400">
                        <li><a href="#servicios" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Computadores, Notebooks &amp; Mac</a></li>
                        <li><a href="#servicios" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> iPhone &amp; Pantallas OLED Certificadas</a></li>
                        <li><a href="#servicios" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> PlayStation 5, Xbox Series &amp; Switch</a></li>
                        <li><a href="#microsoldadura" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Microsoldadura &amp; Reparación de Placas</a></li>
                        <li><a href="#servicios" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Estaciones Gamer &amp; Optimización Térmica</a></li>
                        <li><a href="#servicios" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Recuperación de Datos SSD &amp; Discos</a></li>
                    </ul>
                </div>

                <!-- Col 3: Soluciones B2B (Lg: col-span-2) -->
                <div class="lg:col-span-2 space-y-3">
                    <div class="text-xs font-semibold uppercase tracking-wider text-white">Soporte Empresas</div>
                    <ul class="space-y-2 text-neutral-400">
                        <li><a href="#empresas" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Convenios y Flotas TI</a></li>
                        <li><a href="#empresas" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Redes &amp; Wi-Fi Corporativo</a></li>
                        <li><a href="#empresas" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Servidores &amp; Respaldo Nube</a></li>
                        <li><a href="#empresas" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Software a Medida &amp; POS</a></li>
                        <li><a href="#empresas" class="hover:text-white transition flex items-center gap-1.5"><span class="text-neutral-600">›</span> Facturación Electrónica OC</a></li>
                    </ul>
                </div>

                <!-- Col 4: Portal Digital & Atención (Lg: col-span-3) -->
                <div class="lg:col-span-3 space-y-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-white">Portal &amp; Atención</div>

                    <!-- Mini OT Tracker Portal Box -->
                    <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.08] space-y-2.5">
                        <div class="flex items-center gap-2 text-white font-medium text-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>Seguimiento Digital OT</span>
                        </div>
                        <p class="text-[11px] text-neutral-400 leading-relaxed">
                            ¿Tienes un equipo ingresado? Consulta el estado de tu orden en tiempo real con tu código.
                        </p>
                        <a href="#rastreo" class="inline-flex items-center gap-1.5 text-xs text-white hover:text-neutral-200 font-semibold group/track">
                            <span>Consultar Orden de Trabajo</span>
                            <span class="group-hover/track:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>

                    <!-- Horarios & Acceso -->
                    <div class="space-y-1.5 text-[11px] text-neutral-400">
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-500 font-medium">Horario:</span>
                            <span class="text-neutral-300">Lun a Vie: 09:30 - 19:00 hrs</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-500 font-medium">Sábados:</span>
                            <span class="text-neutral-300">Previa cita / Urgencias B2B</span>
                        </div>
                    </div>

                    <div class="pt-1">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-[11px] text-neutral-400 hover:text-white transition">
                            <svg class="w-3.5 h-3.5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Acceso Interno Taller (ERP)</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Line: Copyright, Quick Links & Back to Top -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-neutral-500 text-xs">
                <div>
                    © {{ date('Y') }} Soin Technology. Todos los derechos reservados.
                </div>

                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs">
                    <a href="#inicio" class="hover:text-neutral-300 transition">Inicio</a>
                    <a href="#rastreo" class="hover:text-neutral-300 transition">Seguimiento OT</a>
                    <a href="#servicios" class="hover:text-neutral-300 transition">Especialidades</a>
                    <a href="#microsoldadura" class="hover:text-neutral-300 transition">Microsoldadura</a>
                    <a href="#empresas" class="hover:text-neutral-300 transition">Empresas</a>
                    <a href="#contacto" class="hover:text-neutral-300 transition">Contacto</a>
                </div>

                <div>
                    <a href="#inicio" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 text-neutral-300 hover:text-white transition text-[11px]">
                        <span>Subir</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</div>
