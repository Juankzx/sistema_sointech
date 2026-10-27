<div class="min-h-screen flex flex-col md:flex-row bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 relative overflow-hidden">
    <!-- Left Hero Column -->
    <div class="hidden md:flex md:w-1/2 relative flex-col justify-between p-12 select-none overflow-hidden z-10 border-r border-white/10"
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
                <span class="text-cyan-300 text-xs font-medium">Centro de Seguridad</span>
            </div>
        </div>

        <div class="relative z-10 max-w-md space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 border border-white/25 text-cyan-200 text-xs font-semibold backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                <span>Seguridad y Privacidad</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Recuperación rápida y segura de tu cuenta.
            </h1>
            <p class="text-sm text-purple-100/90 leading-relaxed">
                Ingresa tu dirección de correo electrónico registrada para restablecer tu contraseña mediante un enlace seguro.
            </p>
        </div>

        <div class="relative z-10 flex items-center justify-between text-xs text-purple-200/80 border-t border-white/15 pt-4">
            <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
            <span class="flex items-center gap-1.5 text-cyan-300 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Conexión Segura SSL
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
                    <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center p-2">
                        <img src="{{ asset('images/logo-dark.png') }}" class="h-8 w-auto object-contain" alt="Sointech Logo">
                    </div>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Restablecer Contraseña</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Te enviaremos un enlace de recuperación a tu correo</p>
            </div>

            @if (session()->has('status'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5">
                    <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="sendResetLink" class="space-y-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">Correo Electrónico Registrado</label>
                    <div class="relative">
                        <x-ui.icon name="mail" class="w-4 h-4 text-purple-500 dark:text-purple-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.cl" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/25 transition">
                    </div>
                    @error('email') 
                        <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        style="background: linear-gradient(135deg, #7c3aed 0%, #db2777 55%, #2563eb 100%);"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-lg shadow-brand-500/30 hover:opacity-95 transition cursor-pointer">
                        <span wire:loading.remove wire:target="sendResetLink">Enviar Enlace de Recuperación</span>
                        <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                            <x-ui.icon name="loader" class="w-4 h-4 animate-spin" />
                            Enviando...
                        </span>
                    </button>
                </div>

                <div class="pt-3 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 dark:text-brand-400 hover:underline transition">
                        <x-ui.icon name="arrow-left" class="w-3.5 h-3.5" />
                        <span>Volver al inicio de sesión</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
