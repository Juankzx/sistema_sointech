<div class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-cyan-500 selection:text-white relative overflow-x-hidden">

    <!-- Glowing Background Accents -->
    <div class="absolute top-0 left-1/4 -translate-x-1/2 w-96 h-96 bg-cyan-600/15 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute top-1/3 right-10 w-96 h-96 bg-blue-600/15 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-10 w-80 h-80 bg-indigo-600/10 blur-3xl rounded-full pointer-events-none"></div>

    <!-- 1. STICKY NAVBAR -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/90 border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 shrink-0 group">
                <img src="{{ isset($settings) && $settings->logo_path ? Storage::url($settings->logo_path) : asset('images/logo-dark.png') }}" 
                     alt="SOINTECH Logo" 
                     class="h-10 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105"
                     onerror="this.onerror=null; this.classList.add('hidden'); document.getElementById('fallback-logo').classList.remove('hidden');"
                >
                <div id="fallback-logo" class="hidden flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-cyan-500/20">
                        S
                    </div>
                    <div>
                        <span class="text-xl font-black tracking-tight text-white group-hover:text-cyan-400 transition-colors">
                            {{ $settings->trade_name ?? 'SOINTECH' }}
                        </span>
                        <span class="block text-[10px] font-medium tracking-wider text-cyan-400 uppercase">Servicios Informáticos</span>
                    </div>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-sm font-medium text-slate-300">
                <a href="#inicio" class="hover:text-cyan-400 transition-colors">Inicio</a>
                <a href="#rastreo" class="hover:text-cyan-400 transition-colors flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    Rastrear Estado
                </a>
                <a href="#servicios" class="hover:text-cyan-400 transition-colors">Servicios</a>
                <a href="#software" class="hover:text-cyan-400 transition-colors">Desarrollo Software</a>
                <a href="#instagram" class="hover:text-cyan-400 transition-colors">Instagram</a>
                <a href="#contacto" class="hover:text-cyan-400 transition-colors">Contacto</a>
            </nav>

            <!-- Actions: Staff Login & Contact -->
            <div class="flex items-center gap-3 shrink-0">
                @auth
                    <a href="{{ request()->getHost() && str_contains(request()->getHost(), 'sointech') ? 'https://taller.sointech.cl/dashboard' : route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-xs font-bold shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.02] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Panel de Taller</span>
                    </a>
                @else
                    <a href="{{ request()->getHost() && str_contains(request()->getHost(), 'sointech') ? 'https://taller.sointech.cl/login' : route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 text-slate-200 text-xs font-bold hover:bg-slate-800 hover:text-white hover:border-slate-600 transition-all shadow-sm">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Acceso Staff / Taller</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- 2. HERO SECTION -->
    <section id="inicio" class="relative pt-10 pb-16 md:pt-16 md:pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Column: Headline & Subtext -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-300 text-xs font-semibold">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Servicio Técnico Especializado & Desarrollo de Software</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                    Soluciones Tecnológicas e <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-cyan-400 via-teal-300 to-blue-500 bg-clip-text text-transparent">Informáticas Integrales</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Servicio técnico avanzado de computadoras, reparación de hardware y desarrollo de sistemas a medida. **Consulta el estado de tu equipo en tiempo real** directamente desde nuestro portal.
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

                <!-- Features Badges -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-slate-800/80 max-w-lg mx-auto lg:mx-0 text-center lg:text-left">
                    <div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-white">Garantía</span>
                        <span class="text-xs text-slate-400">Por escrito</span>
                    </div>
                    <div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-cyan-400">24/48h</span>
                        <span class="text-xs text-slate-400">Diagnóstico técnico</span>
                    </div>
                    <div>
                        <span class="block text-xl sm:text-2xl font-extrabold text-white">24/7</span>
                        <span class="text-xs text-slate-400">Rastreo en línea</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: RASTREO WIDGET (Hero Component) -->
            <div class="lg:col-span-5" id="rastreo">
                <div class="rounded-3xl p-6 sm:p-8 bg-slate-900/90 border border-slate-700/60 shadow-2xl shadow-cyan-950/40 backdrop-blur-xl space-y-5">
                    
                    <!-- Top Tag Inside Box -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-extrabold text-[11px] tracking-wider uppercase rounded-full shadow-md">
                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        Módulo de Consulta en Vivo
                    </div>

                    <div class="space-y-1.5">
                        <h3 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            ¿Tienes un equipo en nuestro taller?
                        </h3>
                        <p class="text-xs text-slate-400">
                            Ingresa tu N° de Orden, Folio o teléfono registrado para verificar el estado de tu reparación.
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

                    <div class="pt-2 text-center">
                        <span class="text-[11px] text-slate-400">¿Dudas con tu comprobante? Escríbenos directamente por WhatsApp.</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. SERVICIOS TÉCNICOS & TI -->
    <section id="servicios" class="py-20 bg-slate-900/50 border-y border-slate-800/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Especialización Técnica</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Servicio Técnico & Soporte Especializado</h2>
                <p class="text-slate-400 text-sm sm:text-base">Mantenimiento preventivo, reparación electrónica y soluciones para equipos particulares y empresas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Servicio 1 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Reparación de Laptops & PC Gamer</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mantenimiento térmico profundo, limpieza de polvo, cambio de pasta térmica de alto rendimiento, pantallas y teclados.
                    </p>
                </div>

                <!-- Servicio 2 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Micro-Soldadura y Electrónica</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Reparación electrónica en tarjeta madre (motherboard), cambio de puertos de carga, diodos, capacitores y líneas en corto.
                    </p>
                </div>

                <!-- Servicio 3 -->
                <div class="rounded-2xl p-6 bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center mb-5 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Actualización SSD & Velocidad</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Instalación de unidades SSD NVMe de ultra velocidad, duplicado/clonación de disco sin perder tus programas ni datos.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. DESARROLLO DE SOFTWARE & SOLUCIONES INFORMÁTICAS -->
    <section id="software" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
            <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Tecnología a Medida</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Desarrollo de Software & Web</h2>
            <p class="text-slate-400 text-sm sm:text-base">Creamos sistemas de gestión, aplicaciones web y software a la medida para potenciar tu negocio.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Software Card 1 -->
            <div class="p-8 rounded-3xl bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 hover:border-cyan-500/40 transition-all space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-xl">
                    💻
                </div>
                <h3 class="text-xl font-bold text-white">Desarrollo de Páginas Web & Landing Pages</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Diseños modernos, optimizados para celulares y posicionamiento en Google (SEO). Ideales para presentar tus productos o servicios.
                </p>
            </div>

            <!-- Software Card 2 -->
            <div class="p-8 rounded-3xl bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 hover:border-cyan-500/40 transition-all space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold text-xl">
                    ⚙️
                </div>
                <h3 class="text-xl font-bold text-white">Sistemas de Gestión, POS & ERP</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Software a medida para inventario, ventas, facturación, control de taller y clientes. Automatiza las operaciones de tu empresa.
                </p>
            </div>

            <!-- Software Card 3 -->
            <div class="p-8 rounded-3xl bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 hover:border-cyan-500/40 transition-all space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center font-bold text-xl">
                    ☁️
                </div>
                <h3 class="text-xl font-bold text-white">Servicios de Nube, Servidores & Redes</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Configuración de servidores cloud (AWS, VPS), respaldo automatizado de bases de datos, redes corporativas y ciberseguridad.
                </p>
            </div>
        </div>
    </section>

    <!-- 5. INSTAGRAM & REDES SOCIALES -->
    <section id="instagram" class="py-16 bg-slate-900/60 border-y border-slate-800/80">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-purple-900/50 to-pink-900/50 border border-pink-500/30 text-pink-300 text-xs font-semibold">
                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                <span>Contenido Diario & Trabajos Reales</span>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Síguenos en Instagram @sointech.cl</h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-xl mx-auto">
                Publicamos casos de éxito de reparación, tips tecnológicos y demostraciones de nuestros proyectos de software.
            </p>

            <div>
                <a href="https://www.instagram.com/sointech.cl" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 text-white font-bold text-sm shadow-xl shadow-pink-500/25 hover:scale-105 transition-all">
                    <span>Visitar Instagram @sointech.cl</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- 6. UBICACIÓN, MAPA & COTIZACIÓN -->
    <section id="contacto" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left: Contact Form -->
            <div class="lg:col-span-7 space-y-6">
                <div class="space-y-2">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Contacto Directo</span>
                    <h2 class="text-3xl font-extrabold text-white">Solicita tu Cotización</h2>
                    <p class="text-slate-400 text-xs sm:text-sm">Déjanos los detalles de tu requerimiento y te responderemos a la brevedad.</p>
                </div>

                <div class="rounded-3xl p-6 sm:p-8 bg-slate-900 border border-slate-800 shadow-2xl">
                    @if($quoteSubmitted)
                        <div class="p-6 rounded-2xl bg-emerald-950/80 border border-emerald-700/80 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center mx-auto font-bold text-xl">
                                ✓
                            </div>
                            <h4 class="text-lg font-bold text-white">¡Mensaje Recibido con Éxito!</h4>
                            <p class="text-xs text-emerald-200">Hemos recibido tu solicitud. Uno de nuestros especialistas te contactará por WhatsApp en breve.</p>
                            <button wire:click="$set('quoteSubmitted', false)" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-700 text-slate-200 text-xs font-bold hover:bg-slate-800 transition-all">
                                Enviar otra consulta
                            </button>
                        </div>
                    @else
                        <form wire:submit.prevent="sendQuoteRequest" class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nombre Completo *</label>
                                    <input type="text" wire:model="contact_name" placeholder="Ej. Carlos Mendoza" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    @error('contact_name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Teléfono / WhatsApp *</label>
                                    <input type="text" wire:model="contact_phone" placeholder="Ej. +56 9 1234 5678" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    @error('contact_phone') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Correo Electrónico (Opcional)</label>
                                    <input type="email" wire:model="contact_email" placeholder="correo@ejemplo.com" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    @error('contact_email') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Categoría del Servicio *</label>
                                    <select wire:model="device_type" class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                        <option value="Servicio Tecnico Laptop/PC">Servicio Técnico Laptop / PC</option>
                                        <option value="Desarrollo Software/Web">Desarrollo de Software / Página Web</option>
                                        <option value="Sistemas POS/ERP">Sistema POS / Inventario a Medida</option>
                                        <option value="Servicios TI Empresas">Servicios TI & Redes para Empresas</option>
                                        <option value="Otro">Otro Requerimiento</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Detalles del Requerimiento *</label>
                                <textarea wire:model="issue_description" rows="4" placeholder="Describe brevemente lo que necesitas (falla de equipo, proyecto de software, etc.)..." class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20"></textarea>
                                @error('issue_description') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-extrabold text-sm shadow-xl shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:scale-[1.01] transition-all">
                                Enviar Solicitud
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Right: Location & Google Maps -->
            <div class="lg:col-span-5 space-y-6">
                <div class="space-y-2">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Encuéntranos</span>
                    <h2 class="text-3xl font-extrabold text-white">Ubicación & Atención</h2>
                </div>

                <div class="rounded-3xl p-6 bg-slate-900 border border-slate-800 space-y-4 text-xs text-slate-300">
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 rounded-xl bg-cyan-950 text-cyan-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <strong class="block text-white text-sm">Dirección</strong>
                            <span>{{ $settings->company_address ?? 'Atención en Taller & Soporte Remoto / Presencial' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="p-2.5 rounded-xl bg-cyan-950 text-cyan-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM3 13a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        <div>
                            <strong class="block text-white text-sm">Contacto Directo</strong>
                            <span>{{ $settings->company_phone ?? '+56 9 1234 5678' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Frame -->
                <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl h-64 bg-slate-900 relative">
                    <iframe 
                        title="Ubicación SOINTECH"
                        class="w-full h-full border-0 filter grayscale contrast-125 opacity-80 hover:opacity-100 transition-opacity"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10000!2d-70.6500!3d-33.4500!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDI3JzAwLjAiUyA3MMKwMzknMDAuMCJX!5e0!3m2!1ses!2scl!4v1600000000000!5m2!1ses!2scl" 
                        allowfullscreen="" 
                        loading="lazy"
                    ></iframe>
                </div>
            </div>

        </div>
    </section>

    <!-- 7. FLOATING WHATSAPP BUTTON -->
    @if(isset($settings) && $settings->company_phone)
        <a 
            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->company_phone) }}?text=Hola%20SOINTECH,%20quisiera%20consultar%20por%20sus%20servicios" 
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

    <!-- 8. FOOTER -->
    <footer class="bg-slate-950 border-t border-slate-900 py-12 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-dark.png') }}" alt="SOINTECH" class="h-6 w-auto object-contain">
                <span class="font-bold text-white text-sm">{{ $settings->trade_name ?? 'SOINTECH' }}</span>
                <span class="text-slate-600">|</span>
                <span>© {{ date('Y') }} Todos los derechos reservados.</span>
            </div>

            <div class="flex items-center gap-6 text-slate-400 font-medium">
                <a href="#inicio" class="hover:text-cyan-400 transition-colors">Inicio</a>
                <a href="#rastreo" class="hover:text-cyan-400 transition-colors">Consulta de Orden</a>
                <a href="#servicios" class="hover:text-cyan-400 transition-colors">Servicios</a>
                <a href="#software" class="hover:text-cyan-400 transition-colors">Software</a>
                <a href="https://www.instagram.com/sointech.cl" target="_blank" class="hover:text-pink-400 transition-colors">Instagram</a>
                <a href="{{ request()->getHost() && str_contains(request()->getHost(), 'sointech') ? 'https://taller.sointech.cl/login' : route('login') }}" class="hover:text-white text-slate-300 font-bold underline decoration-cyan-500 transition-colors">Acceso Sistema Taller</a>
            </div>
        </div>
    </footer>
</div>
