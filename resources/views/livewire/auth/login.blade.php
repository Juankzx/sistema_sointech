<div class="min-h-screen flex flex-col md:flex-row bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 relative overflow-hidden">
    <!-- Decorative Floating Color Orbs (Visible on Mobile & Desktop) -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-purple-600/25 dark:bg-purple-600/30 blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -right-24 w-96 h-96 rounded-full bg-pink-600/20 dark:bg-pink-600/25 blur-3xl"></div>
        <div class="absolute -bottom-28 left-1/3 w-96 h-96 rounded-full bg-cyan-500/20 dark:bg-cyan-500/25 blur-3xl"></div>
    </div>

    <!-- Left Hero Column (MD+ Desktop) -->
    <div class="hidden md:flex md:w-1/2 lg:w-[54%] relative flex-col justify-between p-10 lg:p-14 select-none overflow-hidden z-10"
         style="background: linear-gradient(135deg, #2e1065 0%, #4c1d95 28%, #831843 62%, #1e3a8a 100%);">
        <!-- Subtle background photo with colorful blend -->
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">
        
        <!-- Glowing Mesh Orbs inside Hero -->
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-pink-500/35 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 -left-20 w-96 h-96 rounded-full bg-cyan-400/30 blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full bg-purple-500/25 blur-3xl pointer-events-none"></div>

        <!-- Top Brand Bar -->
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 shadow-lg shadow-purple-950/40">
                    <img src="{{ asset('images/logo-dark.png') }}" class="h-9 w-auto object-contain" alt="Sointech Logo">
                </div>
                <div>
                    <span class="text-white font-extrabold tracking-tight text-lg block leading-none">SOINTECH</span>
                    <span class="text-cyan-300 text-xs font-medium tracking-wide">Sistema de Gestión & Servicio Técnico</span>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-semibold shadow-sm">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                <span class="w-2 h-2 rounded-full bg-cyan-400 -ml-4"></span>
                <span>Plataforma Cloud Activa</span>
            </span>
        </div>

        <!-- Center Hero Copy & Colorful Feature Cards -->
        <div class="relative z-10 max-w-xl space-y-6 my-auto py-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-pink-500/30 via-purple-500/30 to-cyan-500/30 border border-pink-300/30 text-pink-100 text-xs font-bold tracking-wide uppercase shadow-sm backdrop-blur-md">
                <x-ui.icon name="sparkles" class="w-4 h-4 text-cyan-300" />
                <span>Experiencia Rápida, Moderna y Multidispositivo</span>
            </div>

            <h1 class="text-3xl lg:text-5xl font-extrabold tracking-tight text-white leading-[1.15]">
                Control total y energía para tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-pink-300 to-purple-200">taller técnico.</span>
            </h1>

            <p class="text-sm lg:text-base text-purple-100/90 leading-relaxed">
                Administra órdenes de trabajo, evidencia fotográfica, repuestos, caja diaria y notificaciones por WhatsApp desde tu computador o iPhone.
            </p>

            <!-- 4 Colorful Feature Pills -->
            <div class="grid grid-cols-2 gap-3 pt-2">
                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-purple-600/30 shrink-0">
                        <x-ui.icon name="clipboard" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Órdenes & Bitácora</div>
                        <div class="text-[11px] text-purple-200/80">Seguimiento en vivo</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white shadow-md shadow-pink-600/30 shrink-0">
                        <x-ui.icon name="shopping-bag" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Punto de Venta POS</div>
                        <div class="text-[11px] text-purple-200/80">Caja y ventas rápidas</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center text-white shadow-md shadow-cyan-500/30 shrink-0">
                        <x-ui.icon name="package" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Control de Stock</div>
                        <div class="text-[11px] text-purple-200/80">Repuestos e insumos</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 transition">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/30 shrink-0">
                        <x-ui.icon name="whatsapp" class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Avisos WhatsApp</div>
                        <div class="text-[11px] text-purple-200/80">Contacto en 1 clic</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="relative z-10 flex items-center justify-between text-xs text-purple-200/80 border-t border-white/15 pt-4">
            <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
            <span class="flex items-center gap-1.5 text-cyan-300 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Servidores Operativos
            </span>
        </div>
    </div>

    <!-- Right Login Form Column (Full Screen on Mobile / iPhone PWA) -->
    <div class="w-full md:w-1/2 lg:w-[46%] flex flex-col justify-between md:justify-center items-center px-4 py-6 sm:px-10 sm:py-12 relative z-10 min-h-screen md:min-h-0"
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
        <div class="w-full max-w-md flex items-center justify-between md:justify-end mb-4 md:mb-0 md:absolute md:top-6 md:right-8">
            <div class="flex items-center gap-2 md:hidden">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brand-500/15 border border-brand-500/30 text-brand-700 dark:text-brand-300 text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Sointech PWA
                </span>
            </div>
            <button type="button" @click="toggleTheme()"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border border-zinc-200/80 dark:border-zinc-700/80 text-zinc-700 dark:text-zinc-200 shadow-xs hover:scale-105 transition cursor-pointer">
                <template x-if="!isDark">
                    <span class="flex items-center gap-1.5">
                        <x-ui.icon name="moon" class="w-3.5 h-3.5 text-purple-600" />
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
            <!-- Mobile Colorful Hero Header Banner (Only on Mobile / iPhone) -->
            <div class="md:hidden relative overflow-hidden rounded-t-3xl p-6 text-white shadow-lg"
                 style="background: linear-gradient(135deg, #5b21b6 0%, #db2777 55%, #0284c7 100%);">
                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-cyan-300/30 blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="p-2.5 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 shadow-md shrink-0">
                        <img src="{{ asset('images/logo-dark.png') }}" class="h-9 w-auto object-contain" alt="Sointech Logo">
                    </div>
                    <div>
                        <span class="inline-block px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-bold uppercase tracking-wider mb-1">Servicio Técnico</span>
                        <h1 class="text-xl font-extrabold tracking-tight leading-tight">¡Hola de nuevo!</h1>
                        <p class="text-xs text-purple-100/90">Ingresa tus credenciales para continuar</p>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl border border-zinc-200/90 dark:border-zinc-800 rounded-b-3xl md:rounded-3xl p-6 sm:p-10 shadow-xl shadow-purple-950/10 dark:shadow-purple-950/40 relative overflow-hidden">
                <!-- Desktop Top Gradient Accent Bar -->
                <div class="hidden md:block absolute top-0 left-0 right-0 h-2 bg-aurora"></div>

                <!-- Desktop Header -->
                <div class="hidden md:flex flex-col items-center text-center mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-aurora p-0.5 shadow-lg shadow-brand-500/30 mb-3.5">
                        <div class="w-full h-full bg-zinc-950/90 rounded-[14px] flex items-center justify-center p-2">
                            <img src="{{ asset('images/logo-dark.png') }}" class="h-8 w-auto object-contain" alt="Sointech Logo">
                        </div>
                    </div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                        Bienvenido a <span class="text-gradient">Sointech</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Ingresa a tu cuenta para gestionar el taller en tiempo real
                    </p>
                </div>

                <form wire:submit.prevent="login" class="space-y-4">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-zinc-700 dark:text-zinc-200 mb-1.5">
                            Correo Electrónico
                        </label>
                        <div class="relative group">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-300 flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2 transition group-focus-within:bg-purple-600 group-focus-within:text-white">
                                <x-ui.icon name="mail" class="w-4 h-4" />
                            </div>
                            <input wire:model="email" id="email" type="email" autocomplete="email" placeholder="ejemplo@sointech.cl"
                                class="w-full pl-12 pr-4 py-3 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950/90 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
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
                        <label for="password" class="block text-xs font-bold text-zinc-700 dark:text-zinc-200 mb-1.5">
                            Contraseña
                        </label>
                        <div class="relative group">
                            <div class="w-8 h-8 rounded-lg bg-pink-500/10 dark:bg-pink-500/20 text-pink-600 dark:text-pink-300 flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2 transition group-focus-within:bg-pink-600 group-focus-within:text-white">
                                <x-ui.icon name="lock" class="w-4 h-4" />
                            </div>
                            <input wire:model="password" id="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" placeholder="••••••••"
                                class="w-full pl-12 pr-11 py-3 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950/90 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-500/25 transition">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 p-1 cursor-pointer"
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
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-medium text-zinc-600 dark:text-zinc-300 select-none">
                            <input wire:model="remember" type="checkbox" class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-brand-600 focus:ring-brand-500 cursor-pointer">
                            <span>Mantener sesión activa</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-pink-600 dark:text-pink-400 hover:text-brand-600 dark:hover:text-brand-300 hover:underline transition">
                            ¿Olvidaste tu clave?
                        </a>
                    </div>

                    <!-- Vibrant Gradient Submit Button -->
                    <div class="pt-3">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl text-sm font-bold text-white bg-aurora shadow-lg shadow-brand-500/30 hover:shadow-xl hover:shadow-pink-500/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">
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

                <!-- Bottom colorful decorative badges -->
                <div class="mt-6 pt-5 border-t border-zinc-200/80 dark:border-zinc-800 flex items-center justify-center gap-4 text-[11px] text-zinc-500 dark:text-zinc-400">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        Web & iPhone PWA
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-pink-500"></span>
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
        <div class="md:hidden text-center text-[11px] text-zinc-500 dark:text-zinc-400 mt-4 pb-2">
            © {{ date('Y') }} Sointech · Servicio Técnico Profesional
        </div>
    </div>
</div>
