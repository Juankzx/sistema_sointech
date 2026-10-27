<div class="min-h-screen flex flex-col md:flex-row bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 relative overflow-hidden">
    <!-- Left Hero Column -->
    <div class="hidden md:flex md:w-1/2 relative flex-col justify-between p-12 select-none overflow-hidden z-10 border-r border-white/10"
         style="background: linear-gradient(135deg, #2e1065 0%, #4c1d95 30%, #831843 65%, #1e3a8a 100%);">
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-pink-500/35 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 -left-20 w-96 h-96 rounded-full bg-cyan-400/30 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 shadow-lg p-2 flex items-center justify-center shrink-0 overflow-hidden">
                <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
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
        <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 sm:p-10 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-2"
                 style="background: linear-gradient(90deg, #7c3aed 0%, #db2777 50%, #06b6d4 100%);"></div>

            <div class="flex flex-col items-center mb-7 text-center">
                <div class="w-14 h-14 rounded-2xl p-0.5 shadow-lg mb-3.5"
                     style="background: linear-gradient(135deg, #7c3aed, #db2777, #06b6d4);">
                    <div class="w-full h-full bg-slate-100 dark:bg-slate-950 rounded-[14px] flex items-center justify-center p-2 overflow-hidden">
                        <img src="{{ asset('images/logo-light-trans.png') }}" class="w-full h-full object-contain dark:hidden" alt="Sointech Logo">
                        <img src="{{ asset('images/logo-dark-trans.png') }}" class="w-full h-full object-contain hidden dark:block" alt="Sointech Logo">
                    </div>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Nueva Contraseña</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Completa los campos para actualizar tus credenciales</p>
            </div>

            <form wire:submit.prevent="resetPassword" class="space-y-4">
                <input type="hidden" wire:model="token">

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">Confirmar Correo Electrónico</label>
                    <div class="relative">
                        <x-ui.icon name="mail" class="w-4 h-4 text-purple-500 dark:text-purple-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.cl" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
                    </div>
                    @error('email') 
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">Nueva Contraseña</label>
                    <div class="relative">
                        <x-ui.icon name="lock" class="w-4 h-4 text-pink-500 dark:text-pink-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="password" id="password" type="password" placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-500/25 transition">
                    </div>
                    @error('password') 
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">Repetir Contraseña</label>
                    <div class="relative">
                        <x-ui.icon name="lock" class="w-4 h-4 text-cyan-500 dark:text-cyan-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/25 transition">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        style="background: linear-gradient(135deg, #7c3aed 0%, #db2777 55%, #2563eb 100%);"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-lg shadow-brand-500/30 hover:opacity-95 transition cursor-pointer">
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
