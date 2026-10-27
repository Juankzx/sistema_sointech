<div x-data="{ mobileMenu: false }" class="min-h-screen bg-[#16112e] text-slate-100 font-sans selection:bg-pink-500 selection:text-white overflow-x-hidden relative">

    @php
        $cleanPhone = preg_replace('/[^0-9]/', '', $settings->company_phone ?? '56975425132');
        $whatsappUrl = 'https://wa.me/' . ($cleanPhone ?: '56975425132') . '?text=' . urlencode('Hola Sointech, necesito consultar por servicio técnico / soporte informático.');
        $igProfileUrl = $settings->company_instagram ?: 'https://www.instagram.com/sointech.cl';
        if (!str_starts_with($igProfileUrl, 'http')) {
            $igProfileUrl = 'https://www.instagram.com/' . ltrim($igProfileUrl, '@/');
        }
    @endphp

    <!-- Global Ambient Aurora Backdrop -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[38rem] h-[38rem] rounded-full bg-purple-600/20 blur-[140px]"></div>
        <div class="absolute top-20 right-[-10rem] w-[34rem] h-[34rem] rounded-full bg-pink-600/15 blur-[140px]"></div>
        <div class="absolute top-[45%] left-[15%] w-[32rem] h-[32rem] rounded-full bg-cyan-500/12 blur-[150px]"></div>
        <div class="absolute bottom-[-10rem] right-[10%] w-[36rem] h-[36rem] rounded-full bg-blue-600/18 blur-[150px]"></div>
        <!-- Subtle Engineering Grid Overlay -->
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(to right, #38bdf8 1px, transparent 1px), linear-gradient(to bottom, #a855f7 1px, transparent 1px); background-size: 48px 48px;"></div>
    </div>

    <!-- Top Technical Status Bar -->
    <div class="relative z-40 border-b border-purple-400/15 bg-[#110d24]/90 backdrop-blur-md text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-4 text-purple-200/85">
                <span class="inline-flex items-center gap-2 font-semibold text-cyan-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_#34d399]"></span>
                    Laboratorio Electrónico &amp; Soporte TI Activo
                </span>
                @if($settings && $settings->company_address)
                    <span class="hidden md:inline-flex items-center gap-1.5 text-purple-200/75">
                        <svg class="w-3.5 h-3.5 text-pink-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $settings->company_address }}
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-4 ml-auto">
                <a href="{{ $igProfileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-pink-300 hover:text-white font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    @sointech.cl
                </a>
                @if($settings && $settings->company_phone)
                    <span class="text-purple-400/30">|</span>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-emerald-300 hover:text-white font-semibold transition">
                        WhatsApp Directo: {{ $settings->company_phone }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Sticky Navigation -->
    <header class="sticky top-0 z-50 border-b border-purple-400/20 bg-[#16112e]/85 backdrop-blur-2xl shadow-[0_10px_35px_-10px_rgba(10,6,26,0.85)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Identity -->
                <a href="#inicio" class="flex items-center gap-3.5 group">
                    @if($settings && $settings->company_logo)
                        <img src="{{ Storage::url($settings->company_logo) }}" class="h-11 w-auto rounded-xl shadow-lg border border-purple-400/30" alt="{{ $settings->company_name }}">
                    @else
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-purple-600 via-pink-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-purple-600/30 border border-white/20 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-black text-xl sm:text-2xl tracking-tight text-white leading-none">
                            {{ $settings->company_name ?? 'SOINTECH' }}
                        </span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-300 mt-1">
                            Laboratorio &amp; Soluciones TI
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="#rastreo" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Estado de OT
                    </a>
                    <a href="#servicios" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Servicio Técnico
                    </a>
                    <a href="#microsoldadura" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Microsoldadura
                    </a>
                    <a href="#empresas" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Empresas TI
                    </a>
                    <a href="#instagram" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-pink-300 hover:text-white hover:bg-pink-500/15 transition inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span>
                        Casos en Instagram
                    </a>
                    <a href="#contacto" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-purple-100/90 hover:text-white hover:bg-purple-500/15 transition">
                        Cotizar
                    </a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="#contacto" class="px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 text-white shadow-lg shadow-purple-600/25 hover:brightness-110 transition">
                        Solicitar Diagnóstico
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
            <a @click="mobileMenu = false" href="#rastreo" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">Estado de Orden OT</a>
            <a @click="mobileMenu = false" href="#servicios" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">Servicio Técnico (PC · Celulares · Consolas)</a>
            <a @click="mobileMenu = false" href="#microsoldadura" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">Laboratorio de Microsoldadura &amp; Placas</a>
            <a @click="mobileMenu = false" href="#empresas" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-purple-100 hover:bg-purple-500/20">Soluciones Informáticas para Empresas</a>
            <a @click="mobileMenu = false" href="#instagram" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-pink-300 hover:bg-pink-500/20">Trabajos Reales en Instagram (@sointech.cl)</a>
            <a @click="mobileMenu = false" href="#contacto" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-cyan-300 hover:bg-cyan-500/20">Solicitar Diagnóstico / Cotización</a>
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
    <!-- HERO SECTION + LIVE WORK ORDER TRACKER     -->
    <!-- ========================================== -->
    <section id="inicio" class="relative z-10 pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                <!-- Left Column: High-Authority Value Proposition -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#241d42]/90 border border-purple-400/30 shadow-inner">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-gradient-to-r from-pink-500 to-purple-600 text-white">
                            Especialistas
                        </span>
                        <span class="text-xs font-semibold text-purple-100">
                            Electrónica Avanzada · Microsoldadura · Soporte TI Empresas
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl xl:text-[3.4rem] font-black tracking-tight text-white leading-[1.08]">
                        Servicio Técnico de Precisión,
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-purple-300 to-pink-400">
                            Reparación de Placas
                        </span>
                        &amp; Soluciones Informáticas.
                    </h1>

                    <p class="text-base sm:text-lg text-purple-100/80 leading-relaxed max-w-2xl font-normal">
                        Diagnosticamos y reparamos a nivel componente lo que otros talleres dan por perdido. Laboratorio equipado para <strong class="text-white font-semibold">Computadores, Notebooks, Mac, iPhone, Smartphones y Consolas (PS5, Xbox, Switch)</strong>, junto a nuestra división de <strong class="text-cyan-300 font-semibold">Soporte TI, Redes y Software para Empresas</strong>.
                    </p>

                    <!-- Specialty Pills -->
                    <div class="flex flex-wrap gap-2 pt-1">
                        <a href="#servicios" class="px-3.5 py-2 rounded-xl bg-[#221b3f]/90 hover:bg-[#2d2452] border border-purple-400/25 text-xs font-bold text-purple-100 flex items-center gap-2 transition">
                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                            Computadores &amp; Mac
                        </a>
                        <a href="#servicios" class="px-3.5 py-2 rounded-xl bg-[#221b3f]/90 hover:bg-[#2d2452] border border-purple-400/25 text-xs font-bold text-purple-100 flex items-center gap-2 transition">
                            <span class="w-2 h-2 rounded-full bg-pink-400"></span>
                            Celulares &amp; iPhone
                        </a>
                        <a href="#servicios" class="px-3.5 py-2 rounded-xl bg-[#221b3f]/90 hover:bg-[#2d2452] border border-purple-400/25 text-xs font-bold text-purple-100 flex items-center gap-2 transition">
                            <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                            Consolas PS5 · Xbox · Switch
                        </a>
                        <a href="#microsoldadura" class="px-3.5 py-2 rounded-xl bg-[#221b3f]/90 hover:bg-[#2d2452] border border-purple-400/25 text-xs font-bold text-purple-100 flex items-center gap-2 transition">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            Microsoldadura &amp; Placas Madre
                        </a>
                        <a href="#empresas" class="px-3.5 py-2 rounded-xl bg-[#221b3f]/90 hover:bg-[#2d2452] border border-purple-400/25 text-xs font-bold text-purple-100 flex items-center gap-2 transition">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Empresas &amp; Sistemas TI
                        </a>
                    </div>

                    <!-- Primary Hero CTAs -->
                    <div class="flex flex-wrap items-center gap-3.5 pt-2">
                        <a href="#contacto" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 text-white shadow-xl shadow-purple-600/30 hover:brightness-110 transition inline-flex items-center gap-2.5">
                            <span>Cotizar Reparación o Soporte</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3.5 rounded-xl font-bold text-sm bg-[#231c42] hover:bg-[#2e2554] text-emerald-300 border border-emerald-400/35 transition inline-flex items-center gap-2">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/>
                            </svg>
                            Atención Directa WhatsApp
                        </a>
                    </div>

                    <!-- Technical Guarantee Metrics -->
                    <div class="grid grid-cols-3 gap-3 pt-4 border-t border-purple-400/20">
                        <div class="bg-[#211a3e]/70 border border-purple-400/20 rounded-2xl p-3.5">
                            <div class="text-xs font-bold uppercase tracking-wider text-cyan-300">Trazabilidad Digital</div>
                            <p class="text-xs text-purple-200/75 mt-1">Orden de Trabajo con seguimiento en línea, fotos y presupuesto transparente.</p>
                        </div>
                        <div class="bg-[#211a3e]/70 border border-purple-400/20 rounded-2xl p-3.5">
                            <div class="text-xs font-bold uppercase tracking-wider text-pink-300">Nivel Componente</div>
                            <p class="text-xs text-purple-200/75 mt-1">Microscopía trinocular, cámara térmica y esquemáticos para placas madre.</p>
                        </div>
                        <div class="bg-[#211a3e]/70 border border-purple-400/20 rounded-2xl p-3.5">
                            <div class="text-xs font-bold uppercase tracking-wider text-emerald-300">Garantía Escrita</div>
                            <p class="text-xs text-purple-200/75 mt-1">Repuestos seleccionados y pruebas de estrés antes de cada entrega.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Live Work Order Tracking Portal (#rastreo) -->
                <div id="rastreo" class="lg:col-span-5 scroll-mt-28">
                    <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-br from-cyan-400/60 via-purple-500/50 to-pink-500/60 shadow-[0_25px_70px_-15px_rgba(8,5,24,0.9)]">
                        <div class="rounded-[22px] bg-[#1e1838]/95 backdrop-blur-2xl p-6 sm:p-8 space-y-6">

                            <div class="flex items-start justify-between gap-4 border-b border-purple-400/20 pb-5">
                                <div>
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-widest text-cyan-300">
                                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                                        Portal de Clientes en Tiempo Real
                                    </span>
                                    <h2 class="text-xl sm:text-2xl font-black text-white mt-1">
                                        Consulta tu Orden de Trabajo
                                    </h2>
                                    <p class="text-xs text-purple-200/75 mt-1">
                                        Revisa el estado técnico, informe de diagnóstico, repuestos y presupuesto de tu equipo.
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-purple-600/20 border border-cyan-400/30 flex items-center justify-center shrink-0 text-cyan-300">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- 4-Step Live Process Indicator -->
                            <div class="grid grid-cols-4 gap-2 text-center">
                                <div class="p-2.5 rounded-xl bg-[#282147] border border-purple-400/20">
                                    <div class="text-[10px] font-black text-cyan-300 uppercase">Paso 1</div>
                                    <div class="text-[11px] font-semibold text-white mt-0.5">Recepción</div>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#282147] border border-purple-400/20">
                                    <div class="text-[10px] font-black text-purple-300 uppercase">Paso 2</div>
                                    <div class="text-[11px] font-semibold text-white mt-0.5">Diagnóstico</div>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#282147] border border-purple-400/20">
                                    <div class="text-[10px] font-black text-pink-300 uppercase">Paso 3</div>
                                    <div class="text-[11px] font-semibold text-white mt-0.5">Laboratorio</div>
                                </div>
                                <div class="p-2.5 rounded-xl bg-[#282147] border border-purple-400/20">
                                    <div class="text-[10px] font-black text-emerald-300 uppercase">Paso 4</div>
                                    <div class="text-[11px] font-semibold text-white mt-0.5">Listo / Entrega</div>
                                </div>
                            </div>

                            <!-- Search Form -->
                            <form wire:submit="searchOrder" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">
                                        Código de Orden (OT), RUT o Teléfono
                                    </label>
                                    <div class="relative">
                                        <input
                                            wire:model="searchQuery"
                                            type="text"
                                            placeholder="Ej: OT-202610-0012 o tu RUT"
                                            class="w-full px-4 py-3.5 rounded-xl bg-[#151029] border border-purple-400/35 text-white placeholder-purple-300/40 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 text-sm font-medium"
                                        >
                                    </div>
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
                                    class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-cyan-500 via-blue-600 to-purple-600 hover:brightness-110 shadow-lg shadow-cyan-500/25 transition flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <span wire:loading.remove wire:target="searchOrder" class="inline-flex items-center gap-2">
                                        Consultar Estado de mi Equipo
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="searchOrder" class="inline-flex items-center gap-2">
                                        Buscando Orden en Sistema...
                                    </span>
                                </button>
                            </form>

                            <div class="pt-3 border-t border-purple-400/15 flex items-center justify-between text-xs text-purple-200/75">
                                <span>¿Tienes dudas sobre tu orden?</span>
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="font-bold text-cyan-300 hover:text-white underline decoration-cyan-400/50">
                                    Consultar con recepción →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- BENTO GRID: SERVICIO TÉCNICO ESPECIALIZADO (#servicios)    -->
    <!-- ========================================================== -->
    <section id="servicios" class="relative z-10 py-20 border-t border-purple-400/15 bg-[#191334]/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/15 border border-cyan-400/30 text-cyan-300 text-xs font-extrabold uppercase tracking-widest">
                        Áreas de Especialización Técnica
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white mt-3 tracking-tight">
                        Servicio Técnico Multimarca &amp; Electrónica Avanzada
                    </h2>
                    <p class="text-purple-100/75 mt-3 text-base leading-relaxed">
                        Cada equipo ingresa con protocolo de revisión completo, registro fotográfico de recepción y diagnóstico técnico real antes de ejecutar cualquier intervención.
                    </p>
                </div>
                <a href="#contacto" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#261f47] hover:bg-[#31285a] border border-purple-400/30 text-xs font-bold uppercase tracking-wider text-cyan-300 transition">
                    <span>Agendar Revisión en Taller</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- 6 Specialized Service Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- 1. Computadores, Notebooks & Mac -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-cyan-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-500/15 border border-cyan-400/35 flex items-center justify-center text-cyan-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-cyan-500/15 text-cyan-300 border border-cyan-400/30">
                                Windows · MacBook · Gamer
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-cyan-300 transition">
                            Computadores, Notebooks &amp; Mac
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Servicio integral para portátiles corporativos, notebooks gamer y línea Apple (MacBook Air / Pro &amp; iMac).
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 font-black">✓</span>
                                <span>Mantención térmica preventiva con pasta de alta conductividad y thermal pads calibrados.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 font-black">✓</span>
                                <span>Reemplazo de pantallas LED/IPS, teclados, baterías, conectores DC Jack y reconstrucción de bisagras.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-cyan-400 font-black">✓</span>
                                <span>Upgrade de velocidad con SSD NVMe M.2, ampliación de RAM DDR4/DDR5 y optimización de sistema.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-cyan-500 hover:text-slate-950 text-cyan-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Notebook / PC</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Celulares & Tablets (iPhone / Android) -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-pink-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-pink-500/15 border border-pink-400/35 flex items-center justify-center text-pink-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-pink-500/15 text-pink-300 border border-pink-400/30">
                                iPhone · Samsung · Xiaomi · iPad
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-pink-300 transition">
                            Servicio Técnico Celulares &amp; Tablets
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Reparación de smartphones y tablets con sellado profesional, calibración de sensores y repuestos de alta fidelidad.
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-pink-400 font-black">✓</span>
                                <span>Cambio de pantallas OLED / Incell / Originales y reemplazo de baterías certificadas.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-pink-400 font-black">✓</span>
                                <span>Reparación de puertos de carga USB-C y Lightning, micrófonos, auriculares, cámaras y tapa trasera.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-pink-400 font-black">✓</span>
                                <span>Tratamiento ultrasónico de emergencia para equipos mojados o con sulfatación interna.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Celular / iPhone / Tablet')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-pink-500 hover:text-white text-pink-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Celular / Tablet</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Consolas de Videojuegos -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-purple-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/15 border border-purple-400/35 flex items-center justify-center text-purple-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-500/15 text-purple-300 border border-purple-400/30">
                                PS5 · PS4 · Xbox Series · Switch
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-purple-300 transition">
                            Servicio Técnico de Consolas
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Especialistas en consolas de nueva generación y portátiles con equipamiento de microsoldadura dedicado.
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-black">✓</span>
                                <span>Reemplazo de puerto HDMI 2.1 dañado e IC de video (Retimer) en PlayStation 5 y Xbox Series X/S.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-black">✓</span>
                                <span>Mantención térmica profunda con recambio de Metal Líquido seguro y limpieza de disipadores.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-purple-400 font-black">✓</span>
                                <span>Nintendo Switch: reparación de puerto USB-C, corto en chip M92T36 / P13USB y drift en controles.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Consola (PS5 / Xbox / Switch)')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-purple-500 hover:text-white text-purple-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Consola</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Microsoldadura & Reparación de Placas Madre -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-amber-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-400/35 flex items-center justify-center text-amber-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-500/15 text-amber-300 border border-amber-400/30">
                                SMD · BGA · Esquemáticos
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-amber-300 transition">
                            Microsoldadura &amp; Placas Madre
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            En vez de cambiar toda la placa a costo de equipo nuevo, localizamos y reparamos el circuito exacto en falla.
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-amber-400 font-black">✓</span>
                                <span>Detección de cortocircuitos en líneas principales y secundarias mediante cámara térmica e inyección de tensión.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-400 font-black">✓</span>
                                <span>Reemplazo de ICs de carga, PMIC, Audio, Backlight, MOSFETs, condensadores SMD y conectores FPC.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-400 font-black">✓</span>
                                <span>Reconstrucción de pistas arrancadas bajo microscopio y reprogramación de chips BIOS / EEPROM.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Microsoldadura / Reparación de Placa Madre')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-amber-500 hover:text-slate-950 text-amber-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Consultar Reparación de Placa</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 5. Recuperación de Datos & Almacenamiento -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-emerald-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-400/35 flex items-center justify-center text-emerald-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-400/30">
                                SSD · NVMe · HDD · Respaldos
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-emerald-300 transition">
                            Rescate de Datos &amp; Almacenamiento
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Extracción segura de información crítica en equipos que no encienden, sistemas corruptos o unidades con sectores dañados.
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-black">✓</span>
                                <span>Recuperación de documentos contables, proyectos de ingeniería, bases de datos y archivos familiares.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-black">✓</span>
                                <span>Clonación forense bit a bit hacia unidades SSD NVMe de alto rendimiento sin perder configuraciones.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-black">✓</span>
                                <span>Implementación de respaldos automáticos locales y en nube para evitar pérdidas futuras.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-emerald-500 hover:text-slate-950 text-emerald-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Solicitar Rescate de Datos</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- 6. Armado de PCs, Estaciones de Trabajo & Gaming -->
                <div class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-blue-400/60 p-7 flex flex-col justify-between transition-all duration-300 shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-400/35 flex items-center justify-center text-blue-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-500/15 text-blue-300 border border-blue-400/30">
                                Workstations · CAD · Gaming
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white group-hover:text-blue-300 transition">
                            Armado de PC &amp; Workstations
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Configuración, ensamblaje profesional y optimización de equipos de alto desempeño para diseño, arquitectura y gaming.
                        </p>

                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 font-black">✓</span>
                                <span>Gestión profesional de cableado, refrigeración líquida AIO y flujo de aire positivo.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 font-black">✓</span>
                                <span>Actualización de BIOS, perfiles EXPO/XMP y pruebas de estabilidad en GPU y CPU bajo carga.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-400 font-black">✓</span>
                                <span>Mantención integral de tarjetas gráficas (GPUs) con pads térmicos de grado industrial.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Servicio Técnico Computador / Notebook / Mac')" class="w-full py-2.5 px-4 rounded-xl bg-[#2a224d] hover:bg-blue-500 hover:text-white text-blue-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Armado o Upgrade</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- LABORATORIO DE MICROSOLDADURA & PLACAS (#microsoldadura)   -->
    <!-- ========================================================== -->
    <section id="microsoldadura" class="relative z-10 py-20 border-t border-purple-400/15">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                <!-- Left Visual Showcase -->
                <div class="lg:col-span-6">
                    <div class="relative rounded-3xl overflow-hidden border border-purple-400/30 shadow-2xl bg-[#1d1738]">
                        <img
                            src="{{ asset('images/login-banner.png') }}"
                            alt="Laboratorio de Microsoldadura y Reparación de Placas Sointech"
                            class="w-full h-[380px] sm:h-[440px] object-cover object-center opacity-90"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#140f29] via-[#140f29]/45 to-transparent"></div>

                        <div class="absolute bottom-0 inset-x-0 p-6 sm:p-8 space-y-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 text-[11px] font-black uppercase tracking-widest">
                                Diagnóstico Electrónico Real
                            </span>
                            <h3 class="text-2xl font-black text-white leading-tight">
                                Reparamos la placa madre original de tu equipo con instrumental de laboratorio.
                            </h3>
                            <p class="text-xs sm:text-sm text-purple-100/85">
                                Evita pagar el costo completo de una placa nueva o perder tu información cuando un notebook, MacBook, iPhone o consola deja de encender.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Engineering Capabilities -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/15 border border-purple-400/30 text-purple-300 text-xs font-extrabold uppercase tracking-widest">
                        Ingeniería Electrónica Aplicada
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        ¿Por qué elegir nuestro Laboratorio de Microsoldadura?
                    </h2>
                    <p class="text-purple-100/80 text-base leading-relaxed">
                        Muchos servicios técnicos solo cambian piezas completas. En <strong class="text-white">Sointech</strong> analizamos las líneas de alimentación y datos en el esquemático oficial del fabricante para sustituir únicamente los microcomponentes dañados.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-5 rounded-2xl bg-[#221b41] border border-purple-400/25">
                            <div class="text-xs font-black uppercase tracking-wider text-cyan-300">01 · Microscopía Trinocular</div>
                            <p class="text-xs text-purple-100/80 mt-2 leading-relaxed">
                                Trabajo de precisión en componentes SMD milimétricos, pistas fracturadas y conectores FPC de alta densidad.
                            </p>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#221b41] border border-purple-400/25">
                            <div class="text-xs font-black uppercase tracking-wider text-pink-300">02 · Termografía Infrarroja</div>
                            <p class="text-xs text-purple-100/80 mt-2 leading-relaxed">
                                Identificación inmediata de fugas de corriente y cortocircuitos sin someter la placa a calor innecesario.
                            </p>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#221b41] border border-purple-400/25">
                            <div class="text-xs font-black uppercase tracking-wider text-amber-300">03 · Esquemáticos &amp; Boardview</div>
                            <p class="text-xs text-purple-100/80 mt-2 leading-relaxed">
                                Medición exacta de voltajes, resistencias y señales de encendido en placas de notebooks, Mac y móviles.
                            </p>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#221b41] border border-purple-400/25">
                            <div class="text-xs font-black uppercase tracking-wider text-emerald-300">04 · Control de Calidad</div>
                            <p class="text-xs text-purple-100/80 mt-2 leading-relaxed">
                                Limpieza ultrasónica posterior al soldado y pruebas de carga prolongada antes de cerrar la orden.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- SOLUCIONES INFORMÁTICAS PARA EMPRESAS (#empresas)          -->
    <!-- ========================================================== -->
    <section id="empresas" class="relative z-10 py-20 border-t border-purple-400/15 bg-gradient-to-b from-[#1a1436] to-[#15102c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mb-14">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-extrabold uppercase tracking-widest">
                    División Corporativa B2B
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-3 tracking-tight">
                    Soluciones Informáticas &amp; Soporte TI para Empresas
                </h2>
                <p class="text-purple-100/80 mt-3 text-base leading-relaxed">
                    Acompañamos a empresas, comercios, contratistas e instituciones con soporte técnico prioritario, continuidad operativa e implementación de software de gestión.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- B2B Pillar 1 -->
                <div class="rounded-3xl bg-[#221b42]/95 border border-purple-400/25 p-7 flex flex-col justify-between shadow-xl">
                    <div>
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-cyan-500/15 text-cyan-300 border border-cyan-400/30">
                            Continuidad Operativa
                        </span>
                        <h3 class="text-xl font-black text-white mt-4">
                            Soporte TI &amp; Mantención de Flotas de Equipos
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Planes mensuales y atención por requerimiento para mantener los computadores de tu empresa rápidos, seguros y operativos.
                        </p>
                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2"><span class="text-cyan-400 font-black">✓</span><span>Mantención preventiva programada de notebooks y estaciones de trabajo.</span></li>
                            <li class="flex items-start gap-2"><span class="text-cyan-400 font-black">✓</span><span>Asistencia remota inmediata y visitas técnicas en terreno.</span></li>
                            <li class="flex items-start gap-2"><span class="text-cyan-400 font-black">✓</span><span>Facturación corporativa e informes técnicos por cada activo intervenido.</span></li>
                        </ul>
                    </div>
                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="w-full py-2.5 px-4 rounded-xl bg-[#2c2352] hover:bg-cyan-500 hover:text-slate-950 text-cyan-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Solicitar Convenio Empresas</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- B2B Pillar 2 -->
                <div class="rounded-3xl bg-[#221b42]/95 border border-purple-400/25 p-7 flex flex-col justify-between shadow-xl">
                    <div>
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-500/15 text-purple-300 border border-purple-400/30">
                            Infraestructura &amp; Cloud
                        </span>
                        <h3 class="text-xl font-black text-white mt-4">
                            Redes Corporativas, Servidores &amp; Seguridad
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Diseño, ordenamiento y estabilización de la conectividad de tu oficina, bodega o sucursal comercial.
                        </p>
                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2"><span class="text-purple-400 font-black">✓</span><span>Redes Wi-Fi empresariales de alta cobertura, routers MikroTik/Ubiquiti y puntos de red.</span></li>
                            <li class="flex items-start gap-2"><span class="text-purple-400 font-black">✓</span><span>Configuración de correos corporativos, servidores cloud (AWS / VPS) y respaldos.</span></li>
                            <li class="flex items-start gap-2"><span class="text-purple-400 font-black">✓</span><span>Auditoría de seguridad, protección ante ransomware y control de accesos.</span></li>
                        </ul>
                    </div>
                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Soluciones Informáticas / Soporte para Empresas')" class="w-full py-2.5 px-4 rounded-xl bg-[#2c2352] hover:bg-purple-500 hover:text-white text-purple-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Evaluar Red / Infraestructura</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- B2B Pillar 3 -->
                <div class="rounded-3xl bg-[#221b42]/95 border border-purple-400/25 p-7 flex flex-col justify-between shadow-xl">
                    <div>
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-pink-500/15 text-pink-300 border border-pink-400/30">
                            Transformación Digital
                        </span>
                        <h3 class="text-xl font-black text-white mt-4">
                            Desarrollo de Software, Sistemas POS &amp; Web
                        </h3>
                        <p class="text-sm text-purple-100/75 mt-2 leading-relaxed">
                            Desarrollamos e implementamos plataformas web, sistemas de gestión interna, control de inventario y puntos de venta.
                        </p>
                        <ul class="mt-5 space-y-2.5 text-xs text-purple-100/90 border-t border-purple-400/20 pt-4">
                            <li class="flex items-start gap-2"><span class="text-pink-400 font-black">✓</span><span>Sistemas web a medida (órdenes de trabajo, inventario, cotizaciones, clientes y reportes).</span></li>
                            <li class="flex items-start gap-2"><span class="text-pink-400 font-black">✓</span><span>Implementación de Puntos de Venta (POS) y páginas web corporativas modernas.</span></li>
                            <li class="flex items-start gap-2"><span class="text-pink-400 font-black">✓</span><span>Despliegue en la nube, soporte continuo y capacitación para tu equipo.</span></li>
                        </ul>
                    </div>
                    <div class="mt-6 pt-4 border-t border-purple-400/15">
                        <a href="#contacto" wire:click="$set('device_type', 'Desarrollo de Software / Sistema POS / Web')" class="w-full py-2.5 px-4 rounded-xl bg-[#2c2352] hover:bg-pink-500 hover:text-white text-pink-300 text-xs font-bold uppercase tracking-wider transition flex items-center justify-between">
                            <span>Cotizar Software o Sistema</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================== -->
    <!-- INSTAGRAM FEED & CASOS REALES (@sointech.cl) (#instagram)  -->
    <!-- ========================================================== -->
    <section id="instagram" class="relative z-10 py-20 border-t border-purple-400/15 bg-[#16112e]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Instagram Profile Header Card -->
            <div class="rounded-3xl bg-gradient-to-r from-[#241c46] via-[#2b1f4f] to-[#211b3e] border border-pink-400/30 p-6 sm:p-8 mb-12 shadow-2xl">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 sm:gap-5">
                        <div class=" p-1 rounded-2xl bg-gradient-to-tr from-amber-400 via-pink-500 to-purple-600 shrink-0 shadow-lg shadow-pink-500/20">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-[#181230] flex items-center justify-center">
                                @if($settings && $settings->company_logo)
                                    <img src="{{ Storage::url($settings->company_logo) }}" alt="Instagram Sointech" class="w-12 h-12 object-contain">
                                @else
                                    <svg class="w-9 h-9 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                                    @sointech.cl
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-pink-500/20 text-pink-300 border border-pink-400/30">
                                    Trabajos Reales de Laboratorio
                                </span>
                            </div>
                            <p class="text-sm text-purple-100/80 mt-1.5 max-w-2xl">
                                Revisa casos reales de microsoldadura, reparación de placas madre, mantención de consolas PS5/Xbox/Switch, notebooks y proyectos TI para empresas.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ $igProfileUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="shrink-0 px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-gradient-to-r from-amber-500 via-pink-600 to-purple-600 text-white shadow-lg shadow-pink-600/30 hover:brightness-110 transition inline-flex items-center gap-2.5"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                        </svg>
                        <span>Seguir en Instagram</span>
                    </a>
                </div>
            </div>

            <!-- Instagram Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($instagramPosts as $post)
                    @php
                        $theme = $post['theme'] ?? 'violet';
                        $gradientMap = [
                            'violet' => 'from-purple-600/35 via-indigo-700/30 to-[#1e183a]',
                            'cyan'   => 'from-cyan-500/35 via-blue-700/30 to-[#1e183a]',
                            'pink'   => 'from-pink-600/35 via-rose-700/30 to-[#1e183a]',
                            'emerald'=> 'from-emerald-500/35 via-teal-700/30 to-[#1e183a]',
                            'amber'  => 'from-amber-500/35 via-orange-700/30 to-[#1e183a]',
                            'blue'   => 'from-blue-500/35 via-indigo-700/30 to-[#1e183a]',
                        ];
                        $badgeMap = [
                            'violet' => 'bg-purple-500/20 text-purple-200 border-purple-400/35',
                            'cyan'   => 'bg-cyan-500/20 text-cyan-200 border-cyan-400/35',
                            'pink'   => 'bg-pink-500/20 text-pink-200 border-pink-400/35',
                            'emerald'=> 'bg-emerald-500/20 text-emerald-200 border-emerald-400/35',
                            'amber'  => 'bg-amber-500/20 text-amber-200 border-amber-400/35',
                            'blue'   => 'bg-blue-500/20 text-blue-200 border-blue-400/35',
                        ];
                        $cardGradient = $gradientMap[$theme] ?? $gradientMap['violet'];
                        $badgeClass = $badgeMap[$theme] ?? $badgeMap['violet'];
                        $postUrl = !empty($post['url']) ? $post['url'] : $igProfileUrl;
                    @endphp

                    <article class="group rounded-3xl bg-[#211b3e]/95 border border-purple-400/25 hover:border-pink-400/50 overflow-hidden flex flex-col justify-between transition-all duration-300 shadow-xl">
                        <div>
                            <!-- Instagram Top Bar -->
                            <div class="px-5 py-3.5 flex items-center justify-between border-b border-purple-400/15 bg-[#1b1534]">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-full bg-gradient-to-tr from-amber-400 via-pink-500 to-purple-600 p-[1.5px] flex items-center justify-center">
                                        <span class="w-full h-full rounded-full bg-[#181230] flex items-center justify-center text-[10px] font-black text-white">S</span>
                                    </span>
                                    <div>
                                        <div class="text-xs font-bold text-white leading-none">sointech.cl</div>
                                        <div class="text-[10px] text-purple-300/70 mt-0.5">{{ $post['date'] ?? 'Laboratorio Sointech' }}</div>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                    {{ $post['category'] ?? 'Servicio Técnico' }}
                                </span>
                            </div>

                            <!-- Post Visual Cover or Uploaded Image -->
                            @if(!empty($post['image']))
                                <div class="relative h-56 overflow-hidden bg-[#151029]">
                                    <img src="{{ Storage::url($post['image']) }}" alt="{{ $post['title'] ?? 'Post Instagram' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#211b3e] via-transparent to-transparent opacity-80"></div>
                                    <div class="absolute bottom-3 left-4 right-4">
                                        <h3 class="text-base font-black text-white drop-shadow">{{ $post['title'] ?? '' }}</h3>
                                    </div>
                                </div>
                            @else
                                <div class="relative h-48 p-6 bg-gradient-to-br {{ $cardGradient }} flex flex-col justify-between overflow-hidden border-b border-purple-400/15">
                                    <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-white/5 blur-xl"></div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-mono uppercase tracking-widest text-purple-200/75">
                                            CASO DE TALLER VERIFICADO
                                        </span>
                                        <svg class="w-5 h-5 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-white leading-snug group-hover:text-cyan-200 transition">
                                            {{ $post['title'] ?? 'Servicio Técnico Especializado' }}
                                        </h3>
                                    </div>
                                </div>
                            @endif

                            <!-- Post Caption -->
                            <div class="p-5">
                                <p class="text-xs sm:text-sm text-purple-100/80 leading-relaxed">
                                    {{ $post['caption'] ?? '' }}
                                </p>
                            </div>
                        </div>

                        <!-- Post Footer -->
                        <div class="px-5 py-3.5 border-t border-purple-400/15 bg-[#1b1534]/60 flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-1.5 text-pink-300 font-semibold">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                {{ $post['likes'] ?? '120' }} me gusta
                            </span>
                            <a href="{{ $postUrl }}" target="_blank" rel="noopener noreferrer" class="font-bold text-cyan-300 hover:text-white inline-flex items-center gap-1 transition">
                                <span>Ver en Instagram</span>
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
                <div class="lg:col-span-5 space-y-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-500/15 border border-pink-400/30 text-pink-300 text-xs font-extrabold uppercase tracking-widest">
                        Atención a Clientes y Empresas
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        Solicita tu Diagnóstico o Cotización Técnica
                    </h2>
                    <p class="text-purple-100/80 text-sm sm:text-base leading-relaxed">
                        Cuéntanos el modelo de tu equipo y la falla que presenta (o el requerimiento informático de tu empresa). Te responderemos a la brevedad por WhatsApp o correo.
                    </p>

                    <div class="space-y-3.5 pt-2">
                        @if($settings && $settings->company_phone)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] hover:bg-[#2a2250] border border-emerald-400/30 transition">
                                <div class="w-11 h-11 rounded-xl bg-emerald-500/15 border border-emerald-400/35 flex items-center justify-center text-emerald-300 shrink-0">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-300">WhatsApp &amp; Teléfono Taller</div>
                                    <div class="text-base font-black text-white mt-0.5">{{ $settings->company_phone }}</div>
                                </div>
                            </a>
                        @endif

                        @if($settings && $settings->company_email)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] border border-purple-400/25">
                                <div class="w-11 h-11 rounded-xl bg-cyan-500/15 border border-cyan-400/35 flex items-center justify-center text-cyan-300 shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-cyan-300">Correo Electrónico</div>
                                    <div class="text-sm font-bold text-white mt-0.5">{{ $settings->company_email }}</div>
                                </div>
                            </div>
                        @endif

                        @if($settings && $settings->company_address)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#221b41] border border-purple-400/25">
                                <div class="w-11 h-11 rounded-xl bg-pink-500/15 border border-pink-400/35 flex items-center justify-center text-pink-300 shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-pink-300">Dirección del Laboratorio</div>
                                    <div class="text-sm font-bold text-white mt-0.5">{{ $settings->company_address }}</div>
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
                                <h3 class="text-2xl font-black text-white">¡Solicitud Recibida Correctamente!</h3>
                                <p class="text-sm text-purple-100/80 max-w-md mx-auto">
                                    Nuestro equipo técnico ha recibido los datos de tu consulta y te contactará a la brevedad.
                                </p>
                                <div class="pt-3 flex flex-wrap justify-center gap-3">
                                    <button wire:click="$set('quoteSubmitted', false)" type="button" class="px-5 py-2.5 rounded-xl bg-[#2d2454] text-xs font-bold uppercase tracking-wider text-purple-100 border border-purple-400/30">
                                        Enviar otra consulta
                                    </button>
                                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-slate-950 text-xs font-bold uppercase tracking-wider">
                                        Hablar ahora por WhatsApp
                                    </a>
                                </div>
                            </div>
                        @else
                            <form wire:submit="sendQuoteRequest" class="space-y-5">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">Nombre o Empresa *</label>
                                        <input wire:model="contact_name" type="text" placeholder="Ej: Juan Pérez / Constructora Atacama" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_name') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">WhatsApp / Teléfono *</label>
                                        <input wire:model="contact_phone" type="text" placeholder="+56 9 1234 5678" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_phone') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">Correo Electrónico (Opcional)</label>
                                        <input wire:model="contact_email" type="email" placeholder="contacto@empresa.cl" class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                        @error('contact_email') <span class="text-rose-400 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">Especialidad Requerida *</label>
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
                                    <label class="block text-xs font-bold uppercase tracking-wider text-purple-200 mb-2">Modelo del Equipo y Descripción de la Falla o Proyecto *</label>
                                    <textarea wire:model="issue_description" rows="4" placeholder="Indica marca, modelo exacto y qué síntoma presenta (ej: Notebook Asus TUF no da video, PS5 con puerto HDMI dañado, o requerimiento de soporte TI para 10 equipos de oficina)..." class="w-full px-4 py-3 rounded-xl bg-[#16112e] border border-purple-400/35 text-white placeholder-purple-300/40 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400"></textarea>
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

    <!-- Footer -->
    <footer class="relative z-10 border-t border-purple-400/20 bg-[#110d24] py-10 text-xs text-purple-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="font-black text-white text-sm">{{ $settings->company_name ?? 'SOINTECH' }}</span>
                <span>·</span>
                <span>Servicio Técnico Especializado, Microsoldadura &amp; Soluciones Informáticas</span>
            </div>
            <div class="flex items-center gap-5">
                <a href="#rastreo" class="hover:text-white transition">Seguimiento OT</a>
                <a href="#servicios" class="hover:text-white transition">Especialidades</a>
                <a href="#instagram" class="hover:text-white transition">Instagram</a>
                <a href="{{ route('login') }}" class="text-cyan-300 hover:text-white font-semibold transition">Acceso Taller</a>
            </div>
        </div>
    </footer>

</div>
