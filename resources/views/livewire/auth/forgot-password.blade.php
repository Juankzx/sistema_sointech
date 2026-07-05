<div class="min-h-screen flex flex-col md:flex-row bg-gray-950 overflow-x-hidden">
    
    <!-- LEFT SIDE: Stunning Tech workbench image (50% width on md+, hidden on mobile) -->
    <div class="hidden md:flex md:w-1/2 relative bg-gray-900 overflow-hidden select-none">
        <!-- Background Image -->
        <img src="/images/login-banner.png" alt="Sointech Workspace" class="absolute inset-0 w-full h-full object-cover opacity-60">
        
        <!-- Premium dark neon overlay -->
        <div class="absolute inset-0 bg-gradient-to-tr from-gray-950 via-gray-950/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/10 via-transparent to-purple-500/10"></div>
        
        <!-- Content Overlay -->
        <div class="relative z-10 flex flex-col justify-between p-12 w-full h-full">
            <!-- Branding Header -->
            <div class="flex items-center gap-3">
                <img src="/images/logo-dark.png" class="h-10 w-auto object-contain" alt="Sointech Logo">
            </div>
            
            <!-- Mid Quote / Feature Showcase -->
            <div class="max-w-md">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/25 text-blue-400 text-xs font-semibold mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    Seguridad y Privacidad
                </div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    Tu información está protegida con nosotros.
                </h1>
                <p class="text-gray-400 text-base leading-relaxed">
                    Configura tu contraseña por primera vez de forma privada, o recupérala de forma totalmente segura a través de tu correo electrónico registrado.
                </p>
            </div>
            
            <!-- Footer text -->
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Conexión Segura SSL
                </span>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: Elegant Password Recovery form (50% width on md+, 100% on mobile) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-12 md:px-16 bg-gray-955/90 relative">
        <!-- Tech detail circles -->
        <div class="absolute top-20 right-20 w-72 h-72 bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-purple-600/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="w-full max-w-md bg-gray-900/60 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-blue-500/30">
            
            <!-- Form Header with animated logo on mobile -->
            <div class="flex flex-col items-center mb-8 relative">
                <!-- Logo shown on mobile layout -->
                <div class="md:hidden mb-4">
                    <img src="/images/logo-dark.png" class="h-12 w-auto object-contain" alt="Sointech Logo">
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight text-center">Configurar Contraseña</h2>
                <p class="text-xs sm:text-sm text-gray-400 mt-2 text-center">Ingresa tu correo para configurar por primera vez o restablecer tu cuenta</p>
            </div>

            <!-- Success Status Message -->
            @if (session()->has('status'))
                <div class="mb-6 bg-emerald-950/40 border border-emerald-500/30 text-emerald-300 p-4 rounded-2xl text-xs sm:text-sm leading-relaxed shadow-inner">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form wire:submit.prevent="sendResetLink" class="space-y-6 relative">
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Correo Electrónico Registrado</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.com" 
                            class="w-full bg-gray-950/80 border border-gray-800 rounded-2xl py-3.5 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('email') 
                        <div class="mt-3 bg-red-950/40 border border-red-500/20 text-red-300 p-3 rounded-xl text-xs leading-relaxed">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3.5 px-4 rounded-2xl shadow-xl shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span wire:loading.remove wire:target="sendResetLink" class="flex items-center gap-2">
                            Enviar Enlace de Configuración
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Enviando enlace...
                        </span>
                    </button>
                </div>

                <!-- Volver al Login -->
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
