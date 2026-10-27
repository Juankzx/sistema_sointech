<div class="min-h-screen flex flex-col md:flex-row bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 relative overflow-hidden">
    <!-- Decorative Floating Color Orbs -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-purple-600/25 blur-3xl"></div>
        <div class="absolute top-1/3 -right-24 w-96 h-96 rounded-full bg-pink-600/20 blur-3xl"></div>
        <div class="absolute -bottom-28 left-1/3 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
    </div>

    <!-- Left Hero Column -->
    <div class="hidden md:flex md:w-1/2 relative flex-col justify-between p-12 select-none overflow-hidden z-10"
         style="background: linear-gradient(135deg, #2e1065 0%, #4c1d95 30%, #831843 65%, #1e3a8a 100%);">
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-pink-500/35 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 -left-20 w-96 h-96 rounded-full bg-cyan-400/30 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex items-center gap-3.5">
            <div class="p-2.5 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 shadow-lg">
                <img src="{{ asset('images/logo-dark.png') }}" class="h-9 w-auto object-contain" alt="Sointech Logo">
            </div>
            <div>
                <span class="text-white font-extrabold tracking-tight text-lg block leading-none">SOINTECH</span>
                <span class="text-cyan-300 text-xs font-medium">Actualización de Credenciales</span>
            </div>
        </div>

        <div class="relative z-10 max-w-md space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 border border-white/25 text-cyan-200 text-xs font-semibold backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                <span>Configuración de Acceso</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Establece tu nueva contraseña.
            </h1>
            <p class="text-sm text-purple-100/90 leading-relaxed">
                Ingresa una clave segura para proteger el acceso a tus servicios técnicos y reportes.
            </p>
        </div>

        <div class="relative z-10 flex items-center justify-between text-xs text-purple-200/80 border-t border-white/15 pt-4">
            <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
            <span class="flex items-center gap-1.5 text-cyan-300 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Encriptación Segura
            </span>
        </div>
    </div>

    <!-- Right Form Column -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-4 py-8 sm:px-12 relative z-10">
        <div class="w-full max-w-md bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl border border-zinc-200 dark:border-zinc-800 rounded-3xl p-7 sm:p-10 shadow-xl shadow-purple-950/10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-2 bg-aurora"></div>

            <div class="flex flex-col items-center mb-7 text-center">
                <div class="w-14 h-14 rounded-2xl bg-aurora p-0.5 shadow-lg shadow-brand-500/30 mb-3.5">
                    <div class="w-full h-full bg-zinc-950/90 rounded-[14px] flex items-center justify-center p-2">
                        <img src="{{ asset('images/logo-dark.png') }}" class="h-8 w-auto object-contain" alt="Sointech Logo">
                    </div>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-100">Nueva Contraseña</h2>
                <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Completa los campos para actualizar tus credenciales</p>
            </div>

            <form wire:submit.prevent="resetPassword" class="space-y-4">
                <input type="hidden" wire:model="token">

                <div>
                    <label for="email" class="block text-xs font-bold text-zinc-700 dark:text-zinc-200 mb-1.5">Confirmar Correo Electrónico</label>
                    <div class="relative">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-300 flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2">
                            <x-ui.icon name="mail" class="w-4 h-4" />
                        </div>
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.cl" 
                            class="w-full pl-12 pr-4 py-3 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
                    </div>
                    @error('email') 
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-zinc-700 dark:text-zinc-200 mb-1.5">Nueva Contraseña</label>
                    <div class="relative">
                        <div class="w-8 h-8 rounded-lg bg-pink-500/10 dark:bg-pink-500/20 text-pink-600 dark:text-pink-300 flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2">
                            <x-ui.icon name="lock" class="w-4 h-4" />
                        </div>
                        <input wire:model="password" id="password" type="password" placeholder="••••••••" 
                            class="w-full pl-12 pr-4 py-3 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-500/25 transition">
                    </div>
                    @error('password') 
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-zinc-700 dark:text-zinc-200 mb-1.5">Repetir Contraseña</label>
                    <div class="relative">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-300 flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2">
                            <x-ui.icon name="lock" class="w-4 h-4" />
                        </div>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" placeholder="••••••••" 
                            class="w-full pl-12 pr-4 py-3 text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/25 transition">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl text-sm font-bold text-white bg-aurora shadow-lg shadow-brand-500/30 hover:shadow-xl transition cursor-pointer">
                        <span wire:loading.remove wire:target="resetPassword">Actualizar Contraseña</span>
                        <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                            <x-ui.icon name="loader" class="w-4 h-4 animate-spin" />
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
