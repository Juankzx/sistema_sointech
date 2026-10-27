<div
    x-data="{
        mobileMenu: false,
        scrolled: false,
        activeSlide: 0,
        slides: [
            {
                tag: 'LABORATORIO MULTIMARCA',
                title: 'Servicio Técnico Especializado de Computadores & Mac',
                desc: 'Mantención térmica profunda con pasta de alta conductividad, pantallas, bisagras y upgrades SSD NVMe para portátiles y MacBook Air / Pro.',
                img: '{{ asset('images/landing/notebooks.jpg') }}',
                link: '#servicios',
                color: 'cyan',
                badge: 'Windows · MacBook · Gamer'
            },
            {
                tag: 'ELECTRÓNICA AVANZADA',
                title: 'Microsoldadura SMD/BGA & Reparación de Placas',
                desc: 'Diagnosticamos a nivel componente con microscopio trinocular y termografía infrarroja para salvar la placa madre original de tu equipo.',
                img: '{{ asset('images/landing/microsoldering.jpg') }}',
                link: '#microsoldadura',
                color: 'amber',
                badge: 'Cortos · IC Carga · Reballing'
            },
            {
                tag: 'CONSOLAS DE VIDEOJUEGOS',
                title: 'PlayStation 5, Xbox Series & Nintendo Switch',
                desc: 'Cambio de puerto HDMI 2.1 bajo microscopio, mantención térmica con Metal Líquido certificado y reparación de controles con drift.',
                img: '{{ asset('images/landing/consoles.jpg') }}',
                link: '#servicios',
                color: 'purple',
                badge: 'HDMI 2.1 · Metal Líquido · Drift'
            },
            {
                tag: 'MÓVILES & PANTALLAS OLED',
                title: 'Servicio Técnico iPhone, Smartphones & Tablets',
                desc: 'Reemplazo de pantallas OLED de alta fidelidad, cambio de baterías certificadas, puertos USB-C/Lightning y tratamiento ultrasónico.',
                img: '{{ asset('images/landing/mobile.jpg') }}',
                link: '#servicios',
                color: 'pink',
                badge: 'iPhone · Samsung · iPad'
            },
            {
                tag: 'DIVISIÓN CORPORATIVA B2B',
                title: 'Soluciones Informáticas & Soporte TI para Empresas',
                desc: 'Mantención preventiva de flotas de computadores, redes estructuradas Wi-Fi corporativas, servidores Cloud y desarrollo de software POS a medida.',
                img: '{{ asset('images/landing/b2b.jpg') }}',
                link: '#empresas',
                color: 'emerald',
                badge: 'Soporte Empresas · Redes · POS'
            }
        ],
        init() {
            setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 5000);
        }
    }"
    @scroll.window="scrolled = (window.pageYOffset > 40)"
    class="min-h-screen bg-[#16112e] text-slate-100 font-sans selection:bg-pink-500 selection:text-white overflow-x-hidden relative"
>

    @php
        $whatsappNumber = '+56 9 4529 6314';
        $whatsappClean  = '56945296314';
        $whatsappUrl    = 'https://wa.me/56945296314?text=' . urlencode('Hola Soin Technology, necesito consultar por servicio técnico / soporte.');
        $igProfileUrl   = 'https://www.instagram.com/soin_tech';
    @endphp

    <!-- Global Ambient Aurora Backdrop -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-36 -left-36 w-[38rem] h-[38rem] rounded-full bg-purple-600/25 blur-[140px] animate-pulse-glow"></div>
        <div class="absolute top-16 right-[-10rem] w-[34rem] h-[34rem] rounded-full bg-pink-600/20 blur-[140px] animate-pulse-glow"></div>
        <div class="absolute top-[42%] left-[12%] w-[32rem] h-[32rem] rounded-full bg-cyan-500/15 blur-[150px]"></div>
        <div class="absolute bottom-[-10rem] right-[10%] w-[36rem] h-[36rem] rounded-full bg-blue-600/20 blur-[150px]"></div>
        <div class="absolute inset-0 opacity-[0.035]" style="background-image: linear-gradient(to right, #38bdf8 1px, transparent 1px), linear-gradient(to bottom, #a855f7 1px, transparent 1px); background-size: 48px 48px;"></div>
    </div>

    <!-- Top Status Bar (Cleaned: No address) -->
    <div class="relative z-40 border-b border-purple-400/15 bg-[#110d24]/90 backdrop-blur-md text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3 text-purple-200/90">
                <span class="inline-flex items-center gap-2 font-bold text-cyan-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Laboratorio Electrónico &amp; Soporte TI Activo
                </span>
                <span class="hidden sm:inline text-purple-400/40">|</span>
                <span class="hidden sm:inline text-purple-200/70">Atención técnica garantizada y seguimiento digital</span>
            </div>

            <div class="flex items-center gap-4 ml-auto">
                <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-pink-300 hover:text-white font-bold transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    @soin_tech
                </a>
                <span class="text-purple-400/30">|</span>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-emerald-400 hover:text-white font-bold transition">
                    <!-- WhatsApp Official Logo -->
                    <svg class="w-3.5 h-3.5 text-emerald-400 fill-current" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                    </svg>
                    <span>{{ $whatsappNumber }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Sticky Animated Header (Smooth animation on scroll) -->
    <header
        class="sticky top-0 z-50 transition-all duration-300"
        :class="scrolled ? 'bg-[#16112e]/95 backdrop-blur-2xl shadow-[0_12px_35px_-8px_rgba(10,6,26,0.95)] border-b border-purple-400/30 py-1' : 'bg-[#16112e]/75 backdrop-blur-md border-b border-purple-400/20 py-2.5'"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center transition-all duration-300" :class="scrolled ? 'h-16' : 'h-20'">
                <!-- Soin Technology Official Logo Brand -->
                <a href="#inicio" class="flex items-center gap-3.5 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#130d2a]/90 border border-purple-400/30 shadow-lg shadow-purple-900/30 group-hover:scale-105 group-hover:border-pink-400/60 p-2 transition-all flex items-center justify-center shrink-0 overflow-hidden">
                        <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Soin Technology Logo">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-lg sm:text-2xl tracking-tight text-white leading-none flex items-center gap-1.5">
                            SOIN <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-cyan-300">TECHNOLOGY</span>
                        </span>
                        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-cyan-300 mt-1">
                            Laboratorio &amp; Soluciones TI
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="#inicio" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Inicio
                    </a>
                    <a href="#rastreo" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Seguimiento OT
                    </a>
                    <a href="#servicios" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Especialidades
                    </a>
                    <a href="#microsoldadura" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Microsoldadura
                    </a>
                    <a href="#empresas" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Empresas TI
                    </a>
                    <a href="#instagram" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-pink-300 hover:text-white hover:bg-pink-500/15 transition inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
                        Instagram
                    </a>
                    <a href="#contacto" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Contacto
                    </a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="#contacto" class="px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 text-white shadow-lg shadow-purple-600/25 hover:brightness-110 hover:-translate-y-0.5 transition">
                        Cotizar Ahora
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#261f47] hover:bg-[#31285a] text-cyan-300 border border-cyan-400/30 transition flex items-center gap-2">
                            <span>Panel Taller</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#261f47]/90 hover:bg-[#31285a] text-purple-100 border border-purple-400/30 transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Acceso Taller
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenu = !mobileMenu" type="button" class="lg:hidden p-2.5 rounded-xl bg-[#261f47] border border-purple-400/30 text-purple-100 hover:text-white">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" style="display: none;" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenu" x-transition style="display: none;" class="lg:hidden border-t border-purple-400/20 bg-[#1a1435]/98 backdrop-blur-2xl px-4 pt-3 pb-6 space-y-2">
            <a @click="mobileMenu = false" href="#inicio" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">🏠 Inicio</a>
            <a @click="mobileMenu = false" href="#rastreo" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">🔍 Consultar Orden OT</a>
            <a @click="mobileMenu = false" href="#servicios" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">💻 Especialidades Técnicas</a>
            <a @click="mobileMenu = false" href="#microsoldadura" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">🔬 Microsoldadura &amp; Placas</a>
            <a @click="mobileMenu = false" href="#empresas" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">🏢 Soporte TI para Empresas</a>
            <a @click="mobileMenu = false" href="#instagram" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-pink-300 hover:bg-pink-500/20">📸 Casos en Instagram (@soin_tech)</a>
            <a @click="mobileMenu = false" href="#contacto" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-cyan-300 hover:bg-cyan-500/20">⚡ Solicitar Diagnóstico</a>
            <div class="pt-3 border-t border-purple-400/20 flex gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-cyan-500 text-slate-950">Ir al Panel Taller</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#261f47] text-purple-100 border border-purple-400/30">Acceso Interno Taller</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- HERO SECTION WITH INTERACTIVE CAROUSEL     -->
    <!-- ========================================== -->
    <section id="inicio" class="relative z-10 pt-8 pb-16 lg:pt-12 lg:pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">

                <!-- Left Column: Interactive Hero Carousel -->
                <div class="lg:col-span-7 flex flex-col justify-between">
                    <!-- Carousel Slide Container -->
                    <div class="relative rounded-3xl overflow-hidden border border-purple-400/35 shadow-2xl bg-[#1d1738] min-h-[460px] sm:min-h-[500px] flex flex-col justify-end p-6 sm:p-9">
                        <!-- Slide Background Images with Smooth Crossfade -->
                        <template x-for="(slide, index) in slides" :key="index">
                            <div
                                x-show="activeSlide === index"
                                x-transition:enter="transition-all duration-700 ease-out"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition-all duration-500 ease-in"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute inset-0 z-0"
                            >
                                <img :src="slide.img" :alt="slide.title" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#140e29] via-[#140e29]/75 to-[#140e29]/25"></div>
                            </div>
                        </template>

                        <!-- Content on Top of Active Slide -->
                        <div class="relative z-10 space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#140e29]/80 backdrop-blur-md border border-cyan-400/40 text-cyan-300"
                                    x-text="slides[activeSlide].tag"
                                ></span>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-pink-500/20 backdrop-blur-md text-pink-300 border border-pink-400/30"
                                    x-text="slides[activeSlide].badge"
                                ></span>
                            </div>

                            <h1
                                class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight transition-all duration-300"
                                x-text="slides[activeSlide].title"
                            ></h1>

                            <p
                                class="text-xs sm:text-sm text-purple-100/90 leading-relaxed max-w-xl"
                                x-text="slides[activeSlide].desc"
                            ></p>

                            <!-- Carousel Buttons & Slide Controls -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pt-3 border-t border-purple-400/20">
                                <div class="flex items-center gap-3">
                                    <a :href="slides[activeSlide].link" class="px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-wider bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 text-white shadow-lg hover:brightness-110 transition inline-flex items-center gap-2">
                                        <span>Explorar Especialidad</span>
                                        <span>→</span>
                                    </a>
                                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#231c42]/90 hover:bg-[#2e2554] text-emerald-400 border border-emerald-400/35 transition inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/></svg>
                                        WhatsApp
                                    </a>
                                </div>

                                <!-- Prev / Next / Indicator Pills -->
                                <div class="flex items-center gap-2">
                                    <template x-for="(slide, index) in slides" :key="'dot-'+index">
                                        <button
                                            @click="activeSlide = index"
                                            type="button"
                                            class="h-2 rounded-full transition-all duration-300"
                                            :class="activeSlide === index ? 'w-7 bg-cyan-400' : 'w-2 bg-purple-400/40 hover:bg-purple-300'"
                                            :title="slide.tag"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Live Work Order Tracking Portal (#rastreo) -->
                <div id="rastreo" class="lg:col-span-5 scroll-mt-24 relative flex flex-col justify-center">
                    <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-br from-cyan-400/70 via-purple-500/60 to-pink-500/70 shadow-[0_25px_70px_-15px_rgba(8,5,24,0.9)]">
                        <div class="rounded-[22px] bg-[#1e1838]/95 backdrop-blur-2xl p-6 sm:p-7 space-y-5">

                            <div class="flex items-center gap-3.5 border-b border-purple-400/20 pb-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-500/25 via-purple-500/25 to-pink-500/25 border border-cyan-400/40 flex items-center justify-center shrink-0 text-cyan-300 shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-cyan-300 block">
                                        Portal de Clientes
                                    </span>
                                    <h2 class="text-xl font-black text-white leading-tight">
                                        Rastrea tu Orden (OT)
                                    </h2>
                                    <p class="text-xs text-purple-200/75 mt-0.5">
                                        Fotos de ingreso, diagnóstico y avance en línea.
                                    </p>
                                </div>
                            </div>

                            <!-- Visual 4-Step Workflow Icons -->
                            <div class="grid grid-cols-4 gap-2 text-center">
                                <div class="p-2 rounded-2xl bg-[#282147] border border-cyan-400/25 flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center mb-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-white">Ingreso</span>
                                </div>
                                <div class="p-2 rounded-2xl bg-[#282147] border border-purple-400/25 flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center mb-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-white">Revisión</span>
                                </div>
                                <div class="p-2 rounded-2xl bg-[#282147] border border-pink-400/25 flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-xl bg-pink-500/20 text-pink-300 flex items-center justify-center mb-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-white">Taller</span>
                                </div>
                                <div class="p-2 rounded-2xl bg-[#282147] border border-emerald-400/25 flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center mb-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-white">Listo</span>
                                </div>
                            </div>

                            <!-- Search Form -->
                            <form wire:submit="searchOrder" class="space-y-3.5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">
                                        N° de Orden (OT), RUT o Teléfono
                                    </label>
                                    <input
                                        wire:model="searchQuery"
                                        type="text"
                                        placeholder="Ej: OT-0012 o tu RUT"
                                        class="w-full px-4 py-3.5 rounded-xl bg-[#151029] border border-purple-400/35 text-white placeholder-purple-300/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 text-sm font-medium"
                                    >
                                    @if($searchError)
                                        <div class="mt-2 p-3 rounded-xl bg-rose-500/15 border border-rose-400/35 text-rose-200 text-xs font-semibold flex items-center gap-2">
                                            <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $searchError }}</span>
                                        </div>
                                    @endif
                                </div>

                                <button
                                    type="submit"
                                    class="w-full py-3.5 px-6 rounded-xl font-black text-sm text-white bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 shadow-lg shadow-cyan-500/25 transition flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <span wire:loading.remove wire:target="searchOrder" class="inline-flex items-center gap-2">
                                        Ver Estado de mi Equipo
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="searchOrder">
                                        Buscando Orden...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- ANIMATED MARQUEE TICKER OF BRANDS & SPECIALTIES            -->
    <!-- ========================================================== -->
    <div class="relative z-10 border-y border-purple-400/20 bg-[#120e26]/90 py-3.5 overflow-hidden">
        <div class="animate-marquee flex items-center gap-8 text-xs font-extrabold uppercase tracking-wider text-purple-200/80">
            @for($i = 0; $i < 2; $i++)
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-cyan-400"></span> Apple MacBook &amp; iMac</span>
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-pink-400"></span> iPhone &amp; iPad OLED</span>
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-purple-400"></span> PlayStation 5 · Xbox Series · Nintendo Switch</span>
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Microsoldadura SMD / BGA &amp; Placas Madre</span>
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Notebooks Gamer ASUS ROG · Lenovo Legion · MSI · HP · Dell</span>
                <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Soporte TI Empresas · Redes · Servidores &amp; Sistemas POS</span>
            @endfor
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- BENTO GRID: VISUAL SERVICE CARDS (#servicios)              -->
    <!-- ========================================================== -->
    <section id="servicios" class="relative z-10 py-20 bg-[#191334]/75">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-cyan-500/15 border border-cyan-400/30 text-cyan-300 text-xs font-extrabold uppercase tracking-widest">
                    Nuestras Especialidades
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-3 tracking-tight">
                    Soluciones Reales para Personas, Gamers y Empresas
                </h2>
                <p class="text-purple-100/75 mt-2 text-sm sm:text-base">
                    Selecciona el área que necesitas y agenda tu diagnóstico con garantía escrita.
                </p>
            </div>

            <!-- 6 Visual Cards with Real Photography & Compact Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">

                <!-- 1. Computadores, Notebooks & Mac -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-cyan-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/notebooks.jpg') }}" alt="Servicio Técnico Notebooks y Mac" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-cyan-300 border border-cyan-400/40">
                                Windows · MacBook · Gamer
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-cyan-500 text-slate-950 flex items-center justify-center shadow-lg shadow-cyan-500/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-cyan-300 transition">
                                Computadores, Notebooks &amp; Mac
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                Dejamos tu portátil o Mac rápido, frío y silencioso con repuestos e insumos de grado profesional.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-cyan-200">❄️ Mantención Térmica</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-cyan-200">⚡ Upgrade SSD NVMe &amp; RAM</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-cyan-200">🖥️ Pantallas, Teclados &amp; Bisagras</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-cyan-200">🍎 MacBook Air / Pro</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-600/20 hover:from-cyan-500 hover:to-blue-600 text-cyan-300 hover:text-white border border-cyan-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Notebook / Mac</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Celulares & Tablets (iPhone / Android) -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-pink-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/mobile.jpg') }}" alt="Servicio Técnico iPhone y Celulares" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-pink-300 border border-pink-400/40">
                                iPhone · Samsung · Xiaomi · iPad
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-pink-500 text-white flex items-center justify-center shadow-lg shadow-pink-500/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-pink-300 transition">
                                Celulares, iPhone &amp; Tablets
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                Recambio de componentes con sellado limpio, calibración precisa y rescate por humedad.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-pink-200">📱 Pantallas OLED / Original</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-pink-200">🔋 Baterías Certificadas</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-pink-200">🔌 Puertos USB-C / Lightning</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-pink-200">💧 Limpieza Ultrasónica</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Celular / iPhone / Tablet')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-pink-500/20 to-purple-600/20 hover:from-pink-500 hover:to-purple-600 text-pink-300 hover:text-white border border-pink-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Celular / iPhone</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Consolas de Videojuegos -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-purple-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/consoles.jpg') }}" alt="Servicio Técnico Consolas PS5 Xbox Switch" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-purple-300 border border-purple-400/40">
                                PS5 · PS4 · Xbox Series · Switch
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-purple-600 text-white flex items-center justify-center shadow-lg shadow-purple-600/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-purple-300 transition">
                                Consolas PS5, Xbox &amp; Switch
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                Reparación electrónica y mantención térmica para consolas de nueva generación y portátiles.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-purple-200">📺 Puerto HDMI 2.1 PS5/Xbox</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-purple-200">🧪 Metal Líquido Seguro</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-purple-200">🕹️ Switch USB-C &amp; Chip Carga</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-purple-200">🎮 Reparación Drift Mandos</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Consola (PS5 / Xbox / Switch)')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-purple-500/20 to-indigo-600/20 hover:from-purple-600 hover:to-indigo-600 text-purple-300 hover:text-white border border-purple-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Consola</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Microsoldadura & Reparación de Placas Madre -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-amber-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/microsoldering.jpg') }}" alt="Microsoldadura y Reparación de Placas Madre" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-amber-300 border border-amber-400/40">
                                SMD · BGA · Esquemáticos
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center shadow-lg shadow-amber-500/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-amber-300 transition">
                                Microsoldadura &amp; Placas Madre
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                ¿Tu equipo no enciende o tuvo un corto? Reparamos la placa original a nivel microcomponente.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-amber-200">🔬 Microscopio Trinocular</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-amber-200">🌡️ Cámara Térmica IR</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-amber-200">⚡ Cortos, ICs &amp; Pistas</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-amber-200">💾 Programación BIOS</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Microsoldadura / Reparación de Placa Madre')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-amber-500/20 to-orange-600/20 hover:from-amber-500 hover:to-orange-500 text-amber-300 hover:text-slate-950 border border-amber-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Recuperar Placa Madre</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 5. Workstations, PC Gaming & Rescate de Datos -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-emerald-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/workstation.jpg') }}" alt="Armado de PC Gaming Workstations y Rescate de Datos" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-emerald-300 border border-emerald-400/40">
                                Workstations · Gaming · Datos
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-emerald-500 text-slate-950 flex items-center justify-center shadow-lg shadow-emerald-500/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-emerald-300 transition">
                                Armado PC, GPUs &amp; Rescate de Datos
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                Ensamblaje profesional de alto rendimiento y extracción segura de información en discos dañados.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-emerald-200">🖥️ Armado Pro &amp; Watercooling</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-emerald-200">🎮 Mantención Tarjetas GPU</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-emerald-200">💽 Rescate SSD / HDD</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-emerald-200">☁️ Clonación Sistema</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-500/20 to-teal-600/20 hover:from-emerald-500 hover:to-teal-500 text-emerald-300 hover:text-slate-950 border border-emerald-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar PC / Rescate Datos</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Empresas, Redes & Desarrollo de Software -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-blue-400/70 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                    <div>
                        <div class="relative h-52 overflow-hidden bg-[#140f29]">
                            <img src="{{ asset('images/landing/b2b.jpg') }}" alt="Soluciones Informáticas para Empresas y Software" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-[#211b3e]/30 to-transparent"></div>
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-[#151029]/85 backdrop-blur-md text-blue-300 border border-blue-400/40">
                                Soporte B2B · Redes · Software
                            </span>
                            <div class="absolute bottom-3 right-4 w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/40 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-white group-hover:text-blue-300 transition">
                                Soluciones TI para Empresas
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/75 mt-1.5 leading-relaxed">
                                Tu departamento de informática externo: mantención de flotas, redes, servidores y software a medida.
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-purple-400/15">
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-blue-200">🏢 Convenios Flotas PC</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-blue-200">🌐 Redes Wi-Fi &amp; Routers</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-blue-200">🛒 Sistemas POS &amp; ERP</span>
                                <span class="px-2.5 py-1 rounded-lg bg-[#2b2350] text-[11px] font-semibold text-blue-200">💻 Desarrollo Web</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6">
                        <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-blue-500/20 to-cyan-600/20 hover:from-blue-500 hover:to-cyan-500 text-blue-300 hover:text-white border border-blue-400/35 text-xs font-extrabold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Solicitar Propuesta B2B</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- LABORATORIO DE MICROSOLDADURA (#microsoldadura)            -->
    <!-- ========================================================== -->
    <section id="microsoldadura" class="relative z-10 py-20 border-t border-purple-400/15">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- Left Dual-Image Visual Collage -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-3xl overflow-hidden border border-purple-400/35 shadow-2xl">
                        <img
                            src="{{ asset('images/landing/microsoldering.jpg') }}"
                            alt="Microsoldadura Avanzada Soin Technology"
                            class="w-full h-[360px] sm:h-[420px] object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#140f29] via-transparent to-transparent"></div>
                        <div class="absolute bottom-5 left-5 right-5 sm:right-48 p-4 rounded-2xl bg-[#16112e]/90 backdrop-blur-xl border border-amber-400/35">
                            <span class="text-[10px] font-black uppercase tracking-widest text-amber-300 block">Nivel Componente SMD / BGA</span>
                            <p class="text-sm font-bold text-white mt-0.5">Salvamos tu placa original sin pagar el costo de una placa nueva.</p>
                        </div>
                    </div>

                    <!-- Overlapping Secondary Lab Image -->
                    <div class="hidden sm:block absolute -bottom-6 -right-4 w-48 h-36 rounded-2xl overflow-hidden border-2 border-cyan-400/50 shadow-2xl animate-float-delayed">
                        <img src="{{ asset('images/login-banner.png') }}" alt="Instrumental de Laboratorio" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Right Visual Icon Grid -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/15 border border-amber-400/30 text-amber-300 text-xs font-extrabold uppercase tracking-widest">
                        Electrónica de Precisión
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        Laboratorio de Microsoldadura &amp; Diagnóstico Térmico
                    </h2>
                    <p class="text-purple-100/80 text-sm sm:text-base">
                        Contamos con equipamiento especializado para localizar fallas invisibles a simple vista en placas de notebooks, MacBook, consolas y celulares.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div class="p-4 rounded-2xl bg-[#221b41] border border-purple-400/25 flex items-start gap-3.5 hover:border-cyan-400/50 transition">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center shrink-0 font-black text-lg">🔬</div>
                            <div>
                                <h4 class="text-sm font-black text-white">Microscopía HD</h4>
                                <p class="text-xs text-purple-100/75 mt-0.5">Reconstrucción de pistas, pads y soldadura de microchips SMD.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#221b41] border border-purple-400/25 flex items-start gap-3.5 hover:border-pink-400/50 transition">
                            <div class="w-10 h-10 rounded-xl bg-pink-500/20 text-pink-300 flex items-center justify-center shrink-0 font-black text-lg">🌡️</div>
                            <div>
                                <h4 class="text-sm font-black text-white">Cámara Térmica IR</h4>
                                <p class="text-xs text-purple-100/75 mt-0.5">Detección exacta de cortocircuitos y fugas de consumo en segundos.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#221b41] border border-purple-400/25 flex items-start gap-3.5 hover:border-amber-400/50 transition">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center shrink-0 font-black text-lg">📐</div>
                            <div>
                                <h4 class="text-sm font-black text-white">Boardview &amp; Planos</h4>
                                <p class="text-xs text-purple-100/75 mt-0.5">Seguimiento de líneas de voltaje con esquemáticos oficiales.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#221b41] border border-purple-400/25 flex items-start gap-3.5 hover:border-emerald-400/50 transition">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0 font-black text-lg">🛡️</div>
                            <div>
                                <h4 class="text-sm font-black text-white">Garantía Real</h4>
                                <p class="text-xs text-purple-100/75 mt-0.5">Pruebas de estrés térmico y reporte completo en tu Orden OT.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- DIVISIÓN EMPRESAS & SOLUCIONES TI B2B (#empresas)          -->
    <!-- ========================================================== -->
    <section id="empresas" class="relative z-10 py-20 border-t border-purple-400/15 bg-gradient-to-b from-[#1a1436] to-[#15102c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-[#221b42]/95 border border-purple-400/30 overflow-hidden shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center">

                    <!-- Left Content & 3 Visual B2B Cards -->
                    <div class="lg:col-span-7 p-7 sm:p-10 space-y-6">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-extrabold uppercase tracking-widest">
                            Partner Tecnológico para Empresas
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                            Soporte Informático, Redes &amp; Software para tu Negocio
                        </h2>
                        <p class="text-sm sm:text-base text-purple-100/80">
                            Nos encargamos de la continuidad operativa de tus equipos, la estabilidad de tu red y la digitalización de tu empresa.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                            <div class="p-4 rounded-2xl bg-[#181230] border border-cyan-400/25">
                                <div class="text-2xl mb-1.5">💻</div>
                                <div class="text-xs font-black text-cyan-300 uppercase">Flotas &amp; Soporte</div>
                                <p class="text-xs text-purple-100/75 mt-1">Mantención preventiva y correctiva de PCs y notebooks corporativos.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#181230] border border-purple-400/25">
                                <div class="text-2xl mb-1.5">🌐</div>
                                <div class="text-xs font-black text-purple-300 uppercase">Redes &amp; Cloud</div>
                                <p class="text-xs text-purple-100/75 mt-1">Wi-Fi empresarial, servidores, respaldos y seguridad informática.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#181230] border border-pink-400/25">
                                <div class="text-2xl mb-1.5">🚀</div>
                                <div class="text-xs font-black text-pink-300 uppercase">Software &amp; POS</div>
                                <p class="text-xs text-purple-100/75 mt-1">Sistemas web a medida, control de inventario, ventas y páginas web.</p>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-wrap gap-3">
                            <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 text-slate-950 font-black text-xs uppercase tracking-wider shadow-lg hover:brightness-110 transition">
                                Solicitar Reunión o Convenio Empresa →
                            </a>
                        </div>
                    </div>

                    <!-- Right High-Impact B2B Image -->
                    <div class="lg:col-span-5 relative h-72 lg:h-full min-h-[340px]">
                        <img src="{{ asset('images/landing/b2b.jpg') }}" alt="Soluciones Informáticas Empresas Soin Technology" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#221b42] via-transparent to-transparent hidden lg:block"></div>
                        <div class="absolute bottom-4 right-4 px-4 py-2.5 rounded-2xl bg-[#140f29]/90 backdrop-blur-md border border-emerald-400/40 text-xs font-bold text-emerald-300 animate-float">
                            ✓ Facturación Empresas &amp; SLA Prioritario
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================== -->
    <!-- INSTAGRAM FEED & CASOS REALES (@soin_tech) (#instagram)   -->
    <!-- ========================================================== -->
    <section id="instagram" class="relative z-10 py-20 border-t border-purple-400/15 bg-[#16112e]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Instagram Profile Header Card -->
            <div class="rounded-3xl bg-gradient-to-r from-[#241c46] via-[#2b1f4f] to-[#211b3e] border border-pink-400/35 p-6 sm:p-8 mb-12 shadow-2xl">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 sm:gap-5">
                        <div class="p-1 rounded-2xl bg-gradient-to-tr from-amber-400 via-pink-500 to-purple-600 shrink-0 shadow-lg shadow-pink-500/25">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#181230] p-2 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('images/logo-dark-trans.png') }}" alt="Instagram Soin Technology" class="w-full h-full object-contain">
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                                    @soin_tech
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-pink-500/20 text-pink-300 border border-pink-400/30">
                                    Síguenos en Instagram
                                </span>
                            </div>
                            <p class="text-sm text-purple-100/80 mt-1 max-w-2xl">
                                Mira nuestros trabajos diarios en laboratorio: antes y después, microsoldadura, consolas y equipos corporativos.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ $igProfileUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="shrink-0 px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-gradient-to-r from-amber-500 via-pink-600 to-purple-600 text-white shadow-lg shadow-pink-600/30 hover:brightness-110 hover:-translate-y-0.5 transition inline-flex items-center gap-2.5"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>Ver Perfil @soin_tech</span>
                    </a>
                </div>
            </div>

            <!-- Instagram Visual Photo Grid -->
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
                        $theme = $post['theme'] ?? 'purple';
                        $badgeMap = [
                            'purple' => 'bg-purple-500/20 text-purple-200 border-purple-400/35',
                            'violet' => 'bg-purple-500/20 text-purple-200 border-purple-400/35',
                            'cyan'   => 'bg-cyan-500/20 text-cyan-200 border-cyan-400/35',
                            'pink'   => 'bg-pink-500/20 text-pink-200 border-pink-400/35',
                            'emerald'=> 'bg-emerald-500/20 text-emerald-200 border-emerald-400/35',
                            'amber'  => 'bg-amber-500/20 text-amber-200 border-amber-400/35',
                            'blue'   => 'bg-blue-500/20 text-blue-200 border-blue-400/35',
                        ];
                        $badgeClass = $badgeMap[$theme] ?? $badgeMap['purple'];
                        $postUrl = !empty($post['url']) ? $post['url'] : $igProfileUrl;
                        $photoSrc = !empty($post['image'])
                            ? Storage::url($post['image'])
                            : asset($post['asset_image'] ?? $defaultImages[$idx % count($defaultImages)]);
                    @endphp

                    <article class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-pink-400/60 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 shadow-2xl">
                        <div>
                            <!-- Instagram Card Top Header -->
                            <div class="px-5 py-3.5 flex items-center justify-between border-b border-purple-400/15 bg-[#1b1534]">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-amber-400 via-pink-500 to-purple-600 p-[1.5px] flex items-center justify-center">
                                        <span class="w-full h-full rounded-full bg-[#181230] p-1 flex items-center justify-center overflow-hidden">
                                            <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Soin">
                                        </span>
                                    </span>
                                    <div>
                                        <div class="text-xs font-bold text-white leading-none flex items-center gap-1">
                                            soin_tech
                                            <svg class="w-3.5 h-3.5 text-cyan-400 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                        </div>
                                        <div class="text-[10px] text-purple-300/70 mt-0.5">{{ $post['date'] ?? 'Laboratorio Soin Technology' }}</div>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                    {{ $post['category'] ?? 'Taller' }}
                                </span>
                            </div>

                            <!-- Instagram Square/Landscape Photo with Hover Overlay -->
                            <a href="{{ $postUrl }}" target="_blank" rel="noopener noreferrer" class="block relative h-56 overflow-hidden bg-[#151029]">
                                <img src="{{ $photoSrc }}" alt="{{ $post['title'] ?? 'Post Instagram Soin Technology' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-transparent to-transparent opacity-85"></div>

                                <!-- Instagram Hover Interaction Overlay -->
                                <div class="absolute inset-0 bg-purple-950/55 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-6 text-white font-black text-sm">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-5 h-5 text-pink-400 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                        {{ $post['likes'] ?? '150' }}
                                    </span>
                                    <span class="px-3 py-1.5 rounded-xl bg-white/15 backdrop-blur-md text-xs">Ver en Instagram ↗</span>
                                </div>

                                <div class="absolute bottom-3 left-4 right-4">
                                    <h3 class="text-base font-black text-white drop-shadow-md leading-snug">
                                        {{ $post['title'] ?? 'Servicio Técnico Especializado' }}
                                    </h3>
                                </div>
                            </a>

                            <!-- Short Caption -->
                            <div class="px-5 py-4">
                                <p class="text-xs text-purple-100/80 leading-relaxed line-clamp-3">
                                    <strong class="text-white">soin_tech</strong> {{ $post['caption'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        <!-- Post Footer -->
                        <div class="px-5 py-3 border-t border-purple-400/15 bg-[#1b1534]/60 flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-1.5 text-pink-300 font-bold">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                {{ $post['likes'] ?? '150' }} me gusta
                            </span>
                            <a href="{{ $postUrl }}" target="_blank" rel="noopener noreferrer" class="font-bold text-cyan-300 hover:text-white inline-flex items-center gap-1 transition">
                                <span>Abrir en Instagram</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========================================================== -->
    <!-- FORMULARIO DE COTIZACIÓN & CONTACTO DIRECTO (#contacto)    -->
    <!-- ========================================================== -->
    <section id="contacto" class="relative z-10 py-20 border-t border-purple-400/20 bg-[#191334]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

                <!-- Left Contact Details -->
                <div class="lg:col-span-5 space-y-5">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-pink-500/15 border border-pink-400/30 text-pink-300 text-xs font-extrabold uppercase tracking-widest">
                        Contacto Directo
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        ¿Hablamos sobre tu equipo o empresa?
                    </h2>
                    <p class="text-purple-100/80 text-sm sm:text-base">
                        Escríbenos directamente por WhatsApp o completa el formulario para recibir respuesta inmediata de un técnico especialista.
                    </p>

                    <div class="space-y-3 pt-2">
                        <!-- WhatsApp Direct Card with Authentic WhatsApp Logo -->
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] hover:bg-[#2a2250] border border-emerald-400/35 transition group">
                            <div class="w-13 h-13 rounded-2xl bg-[#25D366]/20 border border-[#25D366]/40 flex items-center justify-center text-[#25D366] shrink-0 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-black uppercase tracking-wider text-emerald-400">WhatsApp Directo Taller</div>
                                <div class="text-base font-black text-white mt-0.5">{{ $whatsappNumber }}</div>
                            </div>
                        </a>

                        <!-- Instagram Profile Card -->
                        <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] hover:bg-[#2a2250] border border-pink-400/35 transition group">
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-amber-500 via-pink-600 to-purple-600 p-[1.5px] shrink-0 group-hover:scale-110 transition-transform shadow-lg">
                                <div class="w-full h-full rounded-2xl bg-[#181230] flex items-center justify-center text-pink-400">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs font-black uppercase tracking-wider text-pink-300">Instagram Oficial</div>
                                <div class="text-base font-black text-white mt-0.5">@soin_tech</div>
                            </div>
                        </a>

                        @if($settings && $settings->company_email)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] border border-purple-400/25">
                                <div class="w-13 h-13 rounded-2xl bg-cyan-500/15 border border-cyan-400/35 flex items-center justify-center text-cyan-300 shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-cyan-300">Correo Corporativo</div>
                                    <div class="text-sm font-bold text-white mt-0.5">{{ $settings->company_email }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Quote Request Form -->
                <div class="lg:col-span-7">
                    <div class="rounded-3xl bg-[#221b41]/95 border border-purple-400/30 p-6 sm:p-9 shadow-2xl">
                        @if($quoteSubmitted)
                            <div class="py-10 text-center space-y-4">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white">¡Solicitud Recibida!</h3>
                                <p class="text-sm text-purple-100/80 max-w-md mx-auto">
                                    Nuestro equipo técnico revisará tu caso y te contactará a la brevedad.
                                </p>
                                <div class="pt-3 flex flex-wrap justify-center gap-3">
                                    <button wire:click="$set('quoteSubmitted', false)" type="button" class="px-5 py-2.5 rounded-xl bg-[#2d2454] text-xs font-bold uppercase tracking-wider text-purple-100 border border-purple-400/30">
                                        Enviar otra consulta
                                    </button>
                                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-slate-950 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-2">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/></svg>
                                        Hablar ahora por WhatsApp
                                    </a>
                                </div>
                            </div>
                        @else
                            <form wire:submit="sendQuoteRequest" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">Nombre o Empresa *</label>
                                        <input wire:model="contact_name" type="text" placeholder="Tu nombre o empresa" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_name') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">WhatsApp / Teléfono *</label>
                                        <input wire:model="contact_phone" type="text" placeholder="+56 9 1234 5678" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_phone') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">Correo (Opcional)</label>
                                        <input wire:model="contact_email" type="email" placeholder="correo@ejemplo.cl" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_email') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">Área o Servicio *</label>
                                        <select wire:model="device_type" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                            <option value="">Selecciona una categoría...</option>
                                            <option value="Servicio Técnico Computador / Notebook / Mac">Servicio Técnico Computador / Notebook / Mac</option>
                                            <option value="Servicio Técnico Celular / iPhone / Tablet">Servicio Técnico Celular / iPhone / Tablet</option>
                                            <option value="Servicio Técnico Consola (PS5 / Xbox / Switch)">Servicio Técnico Consola (PS5 / Xbox / Switch)</option>
                                            <option value="Microsoldadura / Reparación de Placa Madre">Microsoldadura / Reparación de Placa Madre</option>
                                            <option value="Soluciones Informáticas / Soporte para Empresas">Soluciones Informáticas / Soporte para Empresas</option>
                                            <option value="Desarrollo de Software / Sistema POS / Web">Desarrollo de Software / Sistema POS / Web</option>
                                        </select>
                                        @error('device_type') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-1.5">Marca, Modelo y Detalle *</label>
                                    <textarea wire:model="issue_description" rows="3" placeholder="Ej: MacBook Pro no enciende, PS5 sin señal HDMI, o soporte TI para empresa..." class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"></textarea>
                                    @error('issue_description') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="w-full py-4 px-6 rounded-xl font-black text-sm uppercase tracking-wider text-white bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 hover:brightness-110 shadow-xl shadow-purple-600/30 transition cursor-pointer">
                                    Enviar Solicitud al Laboratorio
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Floating Quick-Access WhatsApp Button with Official Logo -->
    <a
        href="{{ $whatsappUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        title="Hablar por WhatsApp con Soin Technology"
        class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 rounded-full bg-[#25D366] text-slate-950 font-black text-xs uppercase tracking-wider shadow-[0_10px_30px_rgba(37,211,102,0.6)] hover:scale-105 hover:bg-[#20bd5a] transition-all"
    >
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/>
        </svg>
        <span class="hidden sm:inline">WhatsApp Directo</span>
    </a>

    <!-- ========================================================== -->
    <!-- IMPROVED MULTI-COLUMN FOOTER                               -->
    <!-- ========================================================== -->
    <footer class="relative z-10 border-t border-purple-400/25 bg-[#0f0b21] pt-14 pb-10 text-xs text-purple-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-purple-400/15">

                <!-- Col 1: Brand & Bio -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="#inicio" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-[#140e29] border border-purple-400/30 p-2 shadow-md flex items-center justify-center overflow-hidden group-hover:border-pink-400/60 transition">
                            <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Soin Technology Logo">
                        </div>
                        <span class="font-black text-xl text-white tracking-tight">SOIN TECHNOLOGY</span>
                    </a>
                    <p class="text-xs text-purple-200/70 leading-relaxed max-w-sm">
                        Laboratorio electrónico especializado en computadores, Mac, consolas de videojuegos, celulares y microsoldadura SMD/BGA, junto a soluciones informáticas integrales para empresas.
                    </p>
                    <div class="flex items-center gap-3 pt-1">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-[#25D366]/15 hover:bg-[#25D366] text-[#25D366] hover:text-slate-950 border border-[#25D366]/35 flex items-center justify-center transition">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z"/></svg>
                        </a>
                        <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-pink-500/15 hover:bg-pink-600 text-pink-300 hover:text-white border border-pink-400/35 flex items-center justify-center transition">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Servicios -->
                <div class="lg:col-span-3 space-y-3">
                    <div class="text-xs font-black uppercase tracking-wider text-white">Servicio Técnico</div>
                    <ul class="space-y-2 text-purple-200/75">
                        <li><a href="#servicios" class="hover:text-cyan-300 transition">Computadores, Notebooks &amp; Mac</a></li>
                        <li><a href="#servicios" class="hover:text-pink-300 transition">Celulares &amp; Pantallas OLED</a></li>
                        <li><a href="#servicios" class="hover:text-purple-300 transition">PlayStation 5, Xbox &amp; Switch</a></li>
                        <li><a href="#microsoldadura" class="hover:text-amber-300 transition">Microsoldadura &amp; Placas Madre</a></li>
                        <li><a href="#servicios" class="hover:text-emerald-300 transition">Armado de PC &amp; Rescate de Datos</a></li>
                    </ul>
                </div>

                <!-- Col 3: Soluciones Empresas & Portal -->
                <div class="lg:col-span-2 space-y-3">
                    <div class="text-xs font-black uppercase tracking-wider text-white">Empresas &amp; Portal</div>
                    <ul class="space-y-2 text-purple-200/75">
                        <li><a href="#empresas" class="hover:text-cyan-300 transition">Soporte TI Flotas PC</a></li>
                        <li><a href="#empresas" class="hover:text-purple-300 transition">Redes &amp; Servidores Cloud</a></li>
                        <li><a href="#empresas" class="hover:text-pink-300 transition">Sistemas Web, POS &amp; ERP</a></li>
                        <li><a href="#rastreo" class="hover:text-cyan-300 transition">Rastreo de Orden OT</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Acceso Interno Taller</a></li>
                    </ul>
                </div>

                <!-- Col 4: Atención Rápida -->
                <div class="lg:col-span-3 space-y-3">
                    <div class="text-xs font-black uppercase tracking-wider text-white">Atención Rápida</div>
                    <div class="p-4 rounded-2xl bg-[#171131] border border-purple-400/20 space-y-2">
                        <div class="flex items-center gap-2 text-emerald-400 font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            WhatsApp: {{ $whatsappNumber }}
                        </div>
                        <p class="text-[11px] text-purple-200/70">
                            Escríbenos para presupuestos, estado de equipos y soporte en terreno.
                        </p>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="mt-2 block w-full text-center py-2 px-3 rounded-xl bg-[#25D366] text-slate-950 font-black text-xs uppercase tracking-wider hover:bg-[#20bd5a] transition">
                            Escribir al WhatsApp →
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Credits -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-purple-300/60 text-xs">
                <div>
                    © {{ date('Y') }} <strong class="text-white">Soin Technology</strong>. Todos los derechos reservados.
                </div>
                <div class="flex items-center gap-6">
                    <a href="#inicio" class="hover:text-white transition">Inicio</a>
                    <a href="#servicios" class="hover:text-white transition">Especialidades</a>
                    <a href="#rastreo" class="hover:text-white transition">Seguimiento OT</a>
                    <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-pink-300 transition">Instagram</a>
                </div>
            </div>
        </div>
    </footer>

</div>
