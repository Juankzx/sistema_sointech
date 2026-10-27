<div class="min-h-screen flex flex-col md:flex-row bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100">
    <!-- Left Hero Column -->
    <div class="hidden md:flex md:w-1/2 relative bg-zinc-900 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 flex-col justify-between p-12 select-none overflow-hidden">
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/70 to-zinc-900/40"></div>

        <div class="relative z-10 flex items-center gap-3">
            <img src="{{ asset('images/logo-dark.png') }}" class="h-9 w-auto object-contain" alt="Sointech Logo">
        </div>

        <div class="relative z-10 max-w-md space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                <span>Seguridad y Privacidad</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-bold tracking-tight text-white leading-tight">
                Recuperación segura de credenciales.
            </h1>
            <p class="text-sm text-zinc-400 leading-relaxed">
                Ingresa tu dirección de correo electrónico registrada para restablecer tu contraseña mediante un enlace seguro.
            </p>
        </div>

        <div class="relative z-10 flex items-center justify-between text-xs text-zinc-500 border-t border-zinc-800/80 pt-4">
            <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
            <span class="flex items-center gap-1.5 text-zinc-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Conexión Segura SSL
            </span>
        </div>
    </div>

    <!-- Right Form Column -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-12 sm:px-12 relative">
        <div class="w-full max-w-md bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-8 sm:p-10 shadow-sm">
            <div class="flex flex-col items-center mb-8">
                <div class="md:hidden mb-4">
                    <img src="{{ asset('images/logo-dark.png') }}" class="h-10 w-auto object-contain" alt="Sointech Logo">
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Restablecer Contraseña</h2>
                <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1 text-center">Te enviaremos un enlace de recuperación a tu casilla</p>
            </div>

            @if (session()->has('status'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5">
                    <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="sendResetLink" class="space-y-4">
                <div>
                    <label for="email" class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Correo Electrónico Registrado</label>
                    <div class="relative">
                        <x-ui.icon name="mail" class="w-4 h-4 text-zinc-400 absolute left-3 top-2.5" />
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.cl" 
                            class="w-full pl-9 pr-3.5 py-2 text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                    </div>
                    @error('email') 
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <span wire:loading.remove wire:target="sendResetLink">Enviar Enlace de Recuperación</span>
                        <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                            <x-ui.icon name="loader" class="w-4 h-4 animate-spin" />
                            Enviando...
                        </span>
                    </button>
                </div>

                <div class="pt-3 text-center">
                    <a href="{{ route('login') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-200 transition">
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
