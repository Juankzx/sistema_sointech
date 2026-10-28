<div class="min-h-screen flex flex-col justify-between items-center px-4 py-8 sm:px-6 lg:px-8 bg-[#f5f5f7] dark:bg-[#090d16] text-slate-900 dark:text-slate-100 transition-colors duration-200 select-none relative"
     x-data="{
         isDark: document.documentElement.classList.contains('dark'),
         toggleTheme() {
             this.isDark = !this.isDark;
             if (this.isDark) {
                 document.documentElement.classList.add('dark');
                 document.documentElement.style.colorScheme = 'dark';
                 localStorage.setItem('theme', 'dark');
             } else {
                 document.documentElement.classList.remove('dark');
                 document.documentElement.style.colorScheme = 'light';
                 localStorage.setItem('theme', 'light');
             }
         }
     }">

    <!-- Top Minimalist Bar -->
    <header class="w-full max-w-4xl flex items-center justify-between py-2">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-colors">
            <x-ui.icon name="arrow-left" class="w-4 h-4" />
            <span>Volver al inicio de sesión</span>
        </a>

        <!-- Apple Glass Theme Switcher -->
        <button type="button" @click="toggleTheme()"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200/80 dark:border-white/10 text-slate-700 dark:text-slate-200 shadow-xs hover:border-slate-400 dark:hover:border-white/20 transition cursor-pointer"
            title="Cambiar tema">
            <template x-if="!isDark">
                <span class="flex items-center gap-1.5">
                    <x-ui.icon name="moon" class="w-3.5 h-3.5 text-slate-700" />
                    <span class="text-[11px]">Modo Oscuro</span>
                </span>
            </template>
            <template x-if="isDark">
                <span class="flex items-center gap-1.5">
                    <x-ui.icon name="sun" class="w-3.5 h-3.5 text-amber-400" />
                    <span class="text-[11px]">Modo Claro</span>
                </span>
            </template>
        </button>
    </header>

    <!-- Center Card: Apple ID Minimalist Monolith -->
    <main class="w-full max-w-[420px] my-auto">
        <div class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-2xl border border-slate-200/90 dark:border-white/[0.08] rounded-3xl p-8 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.06)] dark:shadow-[0_25px_60px_rgba(0,0,0,0.5)] transition-all">

            <!-- Brand Icon & Header -->
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-white/[0.06] border border-slate-200/80 dark:border-white/10 p-3 shadow-xs flex items-center justify-center mb-4 transition-transform hover:scale-105 duration-200">
                    <img src="{{ asset('images/logo-light-trans.png') }}" class="w-full h-full object-contain dark:hidden" alt="Sointech Logo">
                    <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain hidden dark:block" alt="Sointech Logo">
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Nueva Contraseña
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 max-w-xs leading-relaxed">
                    Ingresa y confirma tu nueva clave de acceso para actualizar tu cuenta
                </p>
            </div>

            <form wire:submit.prevent="resetPassword" class="space-y-4">
                <input type="hidden" wire:model="token">

                <div>
                    <label for="email" class="block text-[11px] font-semibold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1.5">
                        Confirmar Correo Electrónico
                    </label>
                    <div class="relative">
                        <x-ui.icon name="mail" class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="email" id="email" type="email" autocomplete="email" placeholder="nombre@sointech.cl" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50/80 dark:bg-white/[0.04] text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0071e3] focus:ring-4 focus:ring-[#0071e3]/15 transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                            <x-ui.icon name="alert-circle" class="w-3.5 h-3.5 shrink-0" />
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-semibold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1.5">
                        Nueva Contraseña
                    </label>
                    <div class="relative">
                        <x-ui.icon name="lock" class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="password" id="password" type="password" placeholder="••••••••" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50/80 dark:bg-white/[0.04] text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0071e3] focus:ring-4 focus:ring-[#0071e3]/15 transition-all">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium flex items-center gap-1">
                            <x-ui.icon name="alert-circle" class="w-3.5 h-3.5 shrink-0" />
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-semibold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1.5">
                        Repetir Nueva Contraseña
                    </label>
                    <div class="relative">
                        <x-ui.icon name="lock" class="w-4 h-4 text-slate-400 dark:text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" placeholder="••••••••" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50/80 dark:bg-white/[0.04] text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0071e3] focus:ring-4 focus:ring-[#0071e3]/15 transition-all">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold text-white bg-[#0071e3] hover:bg-[#0077ed] active:bg-[#0062c4] shadow-sm hover:shadow transition-all duration-150 cursor-pointer active:scale-[0.99]">
                        <span wire:loading.remove wire:target="resetPassword">Guardar Nueva Contraseña</span>
                        <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                            <x-ui.icon name="loader" class="w-4 h-4 animate-spin" />
                            <span>Actualizando...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Clean Apple Footer -->
    <footer class="w-full max-w-4xl flex flex-col sm:flex-row items-center justify-between gap-2 py-4 text-[11px] text-slate-400 dark:text-slate-500">
        <div>
            © {{ date('Y') }} Sointech. Todos los derechos reservados.
        </div>
        <div class="flex items-center gap-4">
            <span class="hover:text-slate-600 dark:hover:text-slate-300 transition">Soporte Técnico</span>
            <span>·</span>
            <span class="hover:text-slate-600 dark:hover:text-slate-300 transition">Seguridad</span>
        </div>
    </footer>
</div>
