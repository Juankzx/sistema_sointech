<div class="min-h-screen flex flex-col md:flex-row bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 relative overflow-hidden">
    <!-- Decorative Floating Color Orbs -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-600/20 dark:bg-blue-600/25 blur-3xl"></div>
        <div class="absolute top-1/3 -right-24 w-96 h-96 rounded-full bg-sky-500/15 dark:bg-sky-500/20 blur-3xl"></div>
        <div class="absolute -bottom-28 left-1/3 w-96 h-96 rounded-full bg-cyan-500/15 dark:bg-cyan-500/20 blur-3xl"></div>
    </div>

    <!-- Left Hero Column (MD+ Desktop) -->
    <div class="hidden md:flex md:w-1/2 relative flex-col justify-between p-12 select-none overflow-hidden z-10 border-r border-slate-800/80"
         style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #1e3a8a 80%, #0369a1 100%);">
        <!-- Subtle background photo with colorful blend -->
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">
        
        <!-- Glowing Mesh Orbs inside Hero -->
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 -left-20 w-96 h-96 rounded-full bg-cyan-400/25 blur-3xl pointer-events-none"></div>

        <!-- Top Brand Bar -->
        <div class="relative z-10 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-lg p-2 flex items-center justify-center shrink-0 overflow-hidden">
                    <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
                </div>
                <div>
                    <span class="text-white font-extrabold tracking-tight text-lg block leading-none">SOINTECH</span>
                    <span class="text-cyan-300 text-xs font-medium tracking-wide">Sistema de Gestión & Servicio Técnico</span>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-semibold shadow-sm">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                <span>Plataforma Cloud Activa</span>
            </span>
        </div>

        <!-- Center Hero Copy & Feature Cards -->
        <div class="relative z-10 max-w-xl space-y-6 my-auto py-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-sky-400/30 text-sky-200 text-xs font-bold tracking-wide uppercase shadow-sm backdrop-blur-md">
                <x-ui.icon name="sparkles" class="w-4 h-4 text-cyan-300" />
                <span>Experiencia Rápida, Moderna y Multidispositivo</span>
            </div>

            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Control total y energía para tu
                <span style="background: linear-gradient(90deg, #38bdf8 0%, #60a5fa 50%, #93c5fd 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">taller técnico.</span>
            </h1>

            <p class="text-sm text-slate-300/90 leading-relaxed">
                Administra órdenes de trabajo, evidencia fotográfica, repuestos, caja diaria y notificaciones por WhatsApp desde tu computador o iPhone.
            </p>

            <!-- 4 Feature Pills -->
            <div class="grid grid-cols-2 gap-3.5 pt-2">
                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-md shrink-0"
                         style="background: linear-gradient(135deg, #2563eb, #0284c7);">
                        <x-ui.icon name="clipboard" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Órdenes & Bitácora</div>
                        <div class="text-[11px] text-slate-300/85">Seguimiento en vivo</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-md shrink-0"
                         style="background: linear-gradient(135deg, #f59e0b, #ea580c);">
                        <x-ui.icon name="shopping-bag" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Punto de Venta POS</div>
                        <div class="text-[11px] text-slate-300/85">Caja y ventas rápidas</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-md shrink-0"
                         style="background: linear-gradient(135deg, #06b6d4, #2563eb);">
                        <x-ui.icon name="package" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Control de Stock</div>
                        <div class="text-[11px] text-slate-300/85">Repuestos e insumos</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-md shrink-0"
                         style="background: linear-gradient(135deg, #10b981, #0d9488);">
                        <x-ui.icon name="whatsapp" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Avisos WhatsApp</div>
                        <div class="text-[11px] text-slate-300/85">Contacto en 1 clic</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="relative z-10 flex items-center justify-between text-xs text-slate-400 border-t border-white/10 pt-4">
            <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
            <span class="flex items-center gap-1.5 text-cyan-300 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Servidores Operativos
            </span>
        </div>
    </div>

    <!-- Right Login Form Column (Full Screen on Mobile / iPhone PWA) -->
    <div class="w-full md:w-1/2 flex flex-col justify-between md:justify-center items-center px-4 py-6 sm:px-12 sm:py-10 relative z-10 min-h-screen md:min-h-0"
         x-data="{
             showPassword: false,
             isDark: document.documentElement.classList.contains('dark'),
             toggleTheme() {
                 this.isDark = !this.isDark;
                 if (this.isDark) {
                     document.documentElement.classList.add('dark');
                     localStorage.setItem('theme', 'dark');
                 } else {
                     document.documentElement.classList.remove('dark');
                     localStorage.setItem('theme', 'light');
                 }
             }
         }">

        <!-- Top Quick Theme Switcher -->
        <div class="w-full max-w-md flex items-center justify-between md:justify-end mb-4">
            <div class="flex items-center gap-2 md:hidden">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-500/15 border border-brand-500/30 text-brand-700 dark:text-brand-300 text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Sointech PWA
                </span>
            </div>
            <button type="button" @click="toggleTheme()"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 shadow-xs hover:border-brand-500 transition cursor-pointer">
                <template x-if="!isDark">
                    <span class="flex items-center gap-1.5">
                        <x-ui.icon name="moon" class="w-3.5 h-3.5 text-sky-600" />
                        <span>Modo Oscuro</span>
                    </span>
                </template>
                <template x-if="isDark">
                    <span class="flex items-center gap-1.5">
                        <x-ui.icon name="sun" class="w-3.5 h-3.5 text-amber-400" />
                        <span>Modo Claro</span>
                    </span>
                </template>
            </button>
        </div>

        <!-- Login Card Container -->
        <div class="w-full max-w-md my-auto animate-fade-in">
            <!-- Mobile Hero Header Banner (Only on Mobile / iPhone) -->
            <div class="md:hidden relative overflow-hidden rounded-t-2xl p-6 text-white shadow-lg"
                 style="background: linear-gradient(135deg, #090d16 0%, #0f172a 45%, #0284c7 100%);">
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 shadow-md p-2 flex items-center justify-center shrink-0 overflow-hidden">
                        <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
                    </div>
                    <div>
                        <span class="inline-block px-2 py-0.5 rounded-md bg-white/15 text-[10px] font-bold uppercase tracking-wider mb-1">Servicio Técnico</span>
                        <h1 class="text-xl font-extrabold tracking-tight leading-tight">¡Hola de nuevo!</h1>
                        <p class="text-xs text-slate-300">Ingresa tus credenciales para continuar</p>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-b-2xl md:rounded-2xl p-8 sm:p-10 shadow-xl relative overflow-hidden">
                <!-- Top Gradient Accent Bar -->
                <div class="hidden md:block absolute top-0 left-0 right-0 h-1.5"
                     style="background: linear-gradient(90deg, #0284c7 0%, #2563eb 50%, #06b6d4 100%);"></div>

                <!-- Desktop Header -->
                <div class="hidden md:flex flex-col items-center text-center mb-8">
                    <div class="w-14 h-14 rounded-2xl p-0.5 shadow-lg mb-3.5"
                         style="background: linear-gradient(135deg, #0284c7, #2563eb, #06b6d4);">
                        <div class="w-full h-full bg-slate-100 dark:bg-slate-950 rounded-[14px] flex items-center justify-center p-2 overflow-hidden">
                            <img src="{{ asset('images/logo-light-trans.png') }}" class="w-full h-full object-contain dark:hidden" alt="Sointech Logo">
                            <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain hidden dark:block" alt="Sointech Logo">
                        </div>
                    </div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Bienvenido a <span style="background: linear-gradient(90deg, #38bdf8, #2563eb, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent;">Sointech</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Ingresa a tu cuenta para gestionar el taller en tiempo real
                    </p>
                </div>

                <form wire:submit.prevent="login" class="space-y-4">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <x-ui.icon name="mail" class="w-4 h-4 text-sky-500 dark:text-sky-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input wire:model="email" id="email" type="email" autocomplete="email" placeholder="ejemplo@sointech.cl"
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold flex items-center gap-1">
                                <x-ui.icon name="alert-circle" class="w-3.5 h-3.5 shrink-0" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Contraseña
                        </label>
                        <div class="relative">
                            <x-ui.icon name="lock" class="w-4 h-4 text-sky-500 dark:text-sky-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input wire:model="password" id="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" placeholder="••••••••"
                                class="w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 p-1 cursor-pointer"
                                tabindex="-1">
                                <template x-if="!showPassword">
                                    <x-ui.icon name="eye" class="w-4 h-4" />
                                </template>
                                <template x-if="showPassword">
                                    <x-ui.icon name="eye-off" class="w-4 h-4" />
                                </template>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-500 font-semibold flex items-center gap-1">
                                <x-ui.icon name="alert-circle" class="w-3.5 h-3.5 shrink-0" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-medium text-slate-600 dark:text-slate-300 select-none">
                            <input wire:model="remember" type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-brand-600 focus:ring-brand-500 cursor-pointer">
                            <span>Mantener sesión activa</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-600 dark:text-brand-400 hover:text-sky-600 dark:hover:text-sky-300 hover:underline transition">
                            ¿Olvidaste tu clave?
                        </a>
                    </div>

                    <!-- Vibrant Gradient Submit Button -->
                    <div class="pt-3">
                        <button type="submit"
                            style="background: linear-gradient(135deg, #2563eb 0%, #0284c7 55%, #0ea5e9 100%);"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-lg shadow-brand-500/30 hover:opacity-95 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">
                            <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                                <span>Ingresar a la Plataforma</span>
                                <x-ui.icon name="arrow-right" class="w-4 h-4" />
                            </span>
                            <span wire:loading wire:target="login" class="flex items-center gap-2">
                                <x-ui.icon name="loader" class="w-4 h-4 animate-spin" />
                                <span>Iniciando sesión...</span>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Bottom decorative badges -->
                <div class="mt-6 pt-5 border-t border-slate-200 dark:border-slate-800 flex items-center justify-center gap-4 text-[11px] text-slate-500 dark:text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        Web & iPhone PWA
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Acceso Seguro
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        Tiempo Real
                    </span>
                </div>
            </div>
        </div>

        <!-- Mobile Footer -->
        <div class="md:hidden text-center text-[11px] text-slate-500 dark:text-slate-400 mt-4 pb-2">
            © {{ date('Y') }} Sointech · Servicio Técnico Profesional
        </div>
    </div>
</div>
