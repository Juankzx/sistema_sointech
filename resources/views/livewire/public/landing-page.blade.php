<div class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-cyan-500 selection:text-white relative overflow-x-hidden">

    <!-- Glowing Background Accents -->
    <div class="absolute top-0 left-1/4 -translate-x-1/2 w-96 h-96 bg-cyan-600/15 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute top-1/3 right-10 w-96 h-96 bg-blue-600/15 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-10 w-80 h-80 bg-indigo-600/10 blur-3xl rounded-full pointer-events-none"></div>

    <!-- 1. STICKY NAVBAR -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                @if(isset($settings) && $settings->logo_path)
                    <img src="{{ Storage::url($settings->logo_path) }}" alt="SOINTECH Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                        S
                    </div>
                @endif
                <div>
                    <span class="text-xl font-black tracking-tight text-white group-hover:text-cyan-400 transition-colors">
                        {{ $settings->trade_name ?? 'SOINTECH' }}
                    </span>
                    <span class="block text-[10px] font-medium tracking-wider text-cyan-400 uppercase">Servicio Técnico Especializado</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#inicio" class="hover:text-cyan-400 transition-colors">Inicio</a>
                <a href="#rastreo" class="hover:text-cyan-400 transition-colors flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    Rastrear Estado
                </a>
                <a href="#servicios" class="hover:text-cyan-400 transition-colors">Servicios</a>
                <a href="#proceso" class="hover:text-cyan-400 transition-colors">Proceso</a>
                <a href="#contacto" class="hover:text-cyan-400 transition-colors">Cotizar</a>
            </nav>

            <!-- Actions: Staff Login & Contact -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ request()->getHost() && str_contains(request()->getHost(), 'sointech') ? 'https://taller.sointech.cl/dashboard' : route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-xs font-bold shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Panel de Taller</span>
                    </a>
                @else
                    <a href="{{ request()->getHost() && str_contains(request()->getHost(), 'sointech') ? 'https://taller.sointech.cl/login' : route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 border border-slate-700/80 text-slate-200 text-xs font-bold hover:bg-slate-800 hover:text-white hover:border-slate-600 transition-all shadow-sm">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Acceso Staff / Taller</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- 2. HERO SECTION -->
    <section id="inicio" class="relative pt-12 pb-20 md:pt-20 md:pb-28 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Copy & Taglines -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-300 text-xs font-semibold">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Diagnóstico Profesional & Garantía por Escrito</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                    Soluciones Técnicas <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-cyan-400 via-teal-300 to-blue-500 bg-clip-text text-transparent">Rápidas, Claras y Transparentes</span>
                </h1>

                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Reparación de laptops, computadoras de escritorio, servidores y equipos de cómputo. Transparencia total: **consulta el estado de tu equipo en tiempo real** desde nuestra web.
                </p>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="#contacto" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-sm shadow-xl shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] transition-all flex items-center gap-2">
                        <span>Solicitar Cotización</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="#rastreo" class="px-6 py-3.5 rounded-xl bg-slate-900 border border-slate-700/80 text-slate-200 hover:text-white hover:bg-slate-800 font-bold text-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Consultar mi Orden</span>
                    </a>
                </div>

                <!-- Stats Badges -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-slate-800/80 max-w-lg mx-auto lg:mx-0 text-center lg:text-left">
                    <div>
                        <span class="block text-2xl font-extrabold text-white">100%</span>
                        <span class="text-xs text-slate-400">Garantizado</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-extrabold text-cyan-400">24/48h</span>
                        <span class="text-xs text-slate-400">Diagnóstico Medio</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-extrabold text-white">En Línea</span>
                        <span class="text-xs text-slate-400">Seguimiento 24/7</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: RASTREO WIDGET (Hero Component) -->
            <div class="lg:col-span-5" id="rastreo">
                <div class="relative rounded-3xl p-6 sm:p-8 bg-slate-900/90 border border-slate-700/60 shadow-2xl shadow-cyan-950/40 backdrop-blur-xl">
                    <div class="absolute -top-3 left-6 px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-extrabold text-[11px] tracking-wider uppercase rounded-full shadow-md">
                        Módulo de Consulta en Vivo
                    </div>

                    <div class="mb-6 space-y-1">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            ¿Tienes un equipo en nuestro taller?
                        </h3>
                        <p class="text-xs text-slate-400">
                            Ingresa tu N° de Orden, Folio o el teléfono registrado para verificar el estado actual de tu reparación.
                        </p>
                    </div>

                    <form wire:submit.prevent="searchOrder" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">Código de Orden o Documento</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    wire:model="searchQuery" 
                                    placeholder="Ej. OT-1042 o tu teléfono"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-slate-500 text-sm font-medium focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all uppercase"
                                >
                                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>

                        @if($searchError)
                            <div class="p-3.5 rounded-xl bg-rose-950/60 border border-rose-800/80 text-rose-300 text-xs flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $searchError }}</span>
                            </div>
                        @endif

                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full py-3.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-extrabold text-sm shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
                        >
                            <span wire:loading.remove>Consultar Estado de Mi Equipo</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Buscando...
                            </span>
                        </button>
                    </form>

                    <div class="mt-5 pt-4 border-t border-slate-800 text-center">
                        <span class="text-[11px] text-slate-500">¿Dudas con tu comprobante? Escríbenos directamente por WhatsApp.</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. SERVICIOS -->
    <section id="servicios" class="py-20 bg-slate-900/50 border-y border-slate-800/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Especialización Técnica</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Nuestros Servicios de Soporte & Taller</h2>
                <p class="text-slate-400 text-sm sm:text-base">Brindamos cobertura completa para equipos de uso personal, profesional y empresarial.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Reparación de Laptops & PC</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mantenimiento interno, cambio de pasta térmica, limpieza profunda, solución a sobrecalentamiento y fallas de encendido.
                    </p>
                </div>

                <!-- Servicio 2 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Micro-Soldadura y Electrónica</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Reparación a nivel de tarjeta madre (motherboard), rebaling, cambio de conectores de carga, diodos y MOSFETs.
                    </p>
                </div>

                <!-- Servicio 3 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Optimización de Disco y SSD</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Actualización a discos de estado sólido (SSD NVMe), clonación de sistema, respaldo seguro de información y formateo.
                    </p>
                </div>

                <!-- Servicio 4 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Pantallas, Flex y Bisagras</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Reemplazo de pantallas quebradas, reparación estructural de bisagras de laptop y reconstrucción de carcasas.
                    </p>
                </div>

                <!-- Servicio 5 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Soporte Técnico a Empresas</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mantenimiento preventivo masivo de flota informática, configuración de servidores, redes estructuradas y pólizas de soporte.
                    </p>
                </div>

                <!-- Servicio 6 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Licencias y Software Original</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Instalación de sistemas operativos, antivirus profesional, suite ofimática y software especializado.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PROCESO DE TRABAJO -->
    <section id="proceso" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Flujo de Trabajo Claro</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">¿Cómo trabajamos en SOINTECH?</h2>
            <p class="text-slate-400 text-sm">Sin sorpresas ni cobros ocultos. Cada paso es informado en tiempo real.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 text-center space-y-3">
                <div class="w-10 h-10 rounded-full bg-cyan-500 text-slate-950 font-black text-sm flex items-center justify-center mx-auto shadow-lg shadow-cyan-500/20">
                    1
                </div>
                <h4 class="font-bold text-white text-base">Recepción & Registro</h4>
                <p class="text-xs text-slate-400">Ingresamos tu equipo al sistema y te entregamos tu comprobante digital con tu código único.</p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 text-center space-y-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 text-cyan-400 font-black text-sm flex items-center justify-center mx-auto border border-slate-700">
                    2
                </div>
                <h4 class="font-bold text-white text-base">Diagnóstico Técnico</h4>
                <p class="text-xs text-slate-400">Nuestros especialistas revisan a fondo la falla y preparan un presupuesto detallado.</p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 text-center space-y-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 text-cyan-400 font-black text-sm flex items-center justify-center mx-auto border border-slate-700">
                    3
                </div>
                <h4 class="font-bold text-white text-base">Aprobación en Línea</h4>
                <p class="text-xs text-slate-400">Recibes la notificación y puedes aprobar o rechazar el presupuesto directamente desde tu celular.</p>
            </div>

            <!-- Step 4 -->
            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 text-center space-y-3">
                <div class="w-10 h-10 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">
                    4
                </div>
                <h4 class="font-bold text-white text-base">Reparación & Entrega</h4>
                <p class="text-xs text-slate-400">Reparamos, probamos el equipo bajo carga extrema y te lo entregamos con tu garantía escrita.</p>
            </div>
        </div>
    </section>

    <!-- 5. FORMULARIO DE COTIZACIÓN / CONTACTO -->
    <section id="contacto" class="py-20 bg-slate-900/50 border-t border-slate-800/80 relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 space-y-3">
                <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Contacto Directo</span>
                <h2 class="text-3xl font-extrabold text-white">Solicita una Cotización o Diagnóstico</h2>
                <p class="text-slate-400 text-sm">Cuéntanos qué falla presenta tu equipo y te responderemos a la brevedad.</p>
            </div>

            <div class="rounded-3xl p-6 sm:p-10 bg-slate-900 border border-slate-800 shadow-2xl">
                @if($quoteSubmitted)
                    <div class="p-6 rounded-2xl bg-emerald-950/80 border border-emerald-700/80 text-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center mx-auto font-bold text-xl">
                            ✓
                        </div>
                        <h4 class="text-lg font-bold text-white">¡Mensaje Recibido con Éxito!</h4>
                        <p class="text-xs text-emerald-200">Hemos recibido tu solicitud. Uno de nuestros técnicos analizará el problema y te contactará por WhatsApp o teléfono en breve.</p>
                        <button wire:click="$set('quoteSubmitted', false)" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-700 text-slate-200 text-xs font-bold hover:bg-slate-800 transition-all">
                            Enviar otra consulta
                        </button>
                    </div>
                @else
                    <form wire:submit.prevent="sendQuoteRequest" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-2">Nombre Completo *</label>
                                <input type="text" wire:model="contact_name" placeholder="Ej. Carlos Mendoza" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('contact_name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-2">Teléfono / WhatsApp *</label>
                                <input type="text" wire:model="contact_phone" placeholder="Ej. +56 9 1234 5678" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('contact_phone') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-2">Correo Electrónico (Opcional)</label>
                                <input type="email" wire:model="contact_email" placeholder="correo@ejemplo.com" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                @error('contact_email') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-2">Tipo de Equipo *</label>
                                <select wire:model="device_type" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    <option value="Laptop">Laptop / Notebook</option>
                                    <option value="PC Escritorio">PC de Escritorio / Gamer</option>
                                    <option value="Impresora">Impresora / Multifuncional</option>
                                    <option value="Servidor/Redes">Servidor / Equipo de Redes</option>
                                    <option value="Otro">Otro Dispositivo Electrónico</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">Descripción de la Falla *</label>
                            <textarea wire:model="issue_description" rows="4" placeholder="Describe brevemente lo que le sucede al equipo (ej. No enciende, se apaga solo, pantalla rota, lento, etc.)..." class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20"></textarea>
                            @error('issue_description') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-extrabold text-sm shadow-xl shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.01] transition-all">
                            Enviar Solicitud de Cotización
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- 6. FLOATING WHATSAPP BUTTON -->
    @if(isset($settings) && $settings->company_phone)
        <a 
            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->company_phone) }}?text=Hola%20SOINTECH,%20necesito%20información%20sobre%20sus%20servicios%20técnicos" 
            target="_blank"
            class="fixed bottom-6 right-6 z-50 p-4 rounded-full bg-emerald-500 text-slate-950 shadow-2xl shadow-emerald-500/40 hover:bg-emerald-400 hover:scale-110 transition-all flex items-center justify-center group"
            title="Contactar por WhatsApp"
        >
            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out text-xs font-extrabold ml-0 group-hover:ml-2">
                WhatsApp Directo
            </span>
        </a>
    @endif

    <!-- 7. FOOTER -->
    <footer class="bg-slate-950 border-t border-slate-900 py-12 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold">
                    S
                </div>
                <span class="font-bold text-white text-sm">{{ $settings->trade_name ?? 'SOINTECH' }}</span>
                <span class="text-slate-600">|</span>
                <span>© {{ date('Y') }} Todos los derechos reservados.</span>
            </div>

            <div class="flex items-center gap-6 text-slate-400 font-medium">
                <a href="#inicio" class="hover:text-cyan-400 transition-colors">Inicio</a>
                <a href="#rastreo" class="hover:text-cyan-400 transition-colors">Consulta de Orden</a>
                <a href="#servicios" class="hover:text-cyan-400 transition-colors">Servicios</a>
                <a href="{{ route('login') }}" class="hover:text-white text-slate-300 font-bold underline decoration-cyan-500 transition-colors">Acceso Sistema Taller</a>
            </div>
        </div>
    </footer>
</div>
