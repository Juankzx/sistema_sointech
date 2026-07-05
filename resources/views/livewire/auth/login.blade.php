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
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/25 text-orange-400 text-xs font-semibold mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                    Sistema de Gestión Profesional
                </div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    Innovación, precisión y confianza para tu equipamiento.
                </h1>
                <p class="text-gray-400 text-base leading-relaxed">
                    Sointech optimiza cada fase del servicio técnico de tus equipos en tiempo real. Gestiona órdenes, clientes e inventario de la forma más práctica y profesional.
                </p>
            </div>
            
            <!-- Footer text -->
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>© {{ date('Y') }} Sointech. Todos los derechos reservados.</span>
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Servidores En Línea
                </span>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: Elegant Login form (50% width on md+, 100% on mobile) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-12 md:px-16 bg-gray-955/90 relative">
        <!-- Tech detail circles -->
        <div class="absolute top-20 right-20 w-72 h-72 bg-orange-600/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-purple-600/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="w-full max-w-md bg-gray-900/60 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-orange-500/30">
            <!-- Form Header with animated logo on mobile -->
            <div class="flex flex-col items-center mb-8 relative">
                <!-- Logo shown on mobile layout -->
                <div class="md:hidden mb-4">
                    <img src="/images/logo-dark.png" class="h-12 w-auto object-contain" alt="Sointech Logo">
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight">Iniciar Sesión</h2>
                <p class="text-sm text-gray-400 mt-2">Ingresa a tu cuenta para administrar la plataforma</p>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="login" class="space-y-5 relative">
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Correo Electrónico</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-orange-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.com" 
                            class="w-full bg-gray-950/80 border border-gray-800 rounded-2xl py-3.5 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('email') 
                        <p class="mt-2 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Contraseña</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-orange-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input wire:model="password" id="password" type="password" placeholder="••••••••" 
                            class="w-full bg-gray-955/80 border border-gray-800 rounded-2xl py-3.5 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('password') 
                        <p class="mt-2 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center space-x-2.5 cursor-pointer text-gray-300 hover:text-white transition duration-200">
                        <input wire:model="remember" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-950 border-gray-800 rounded focus:ring-orange-500/50 focus:ring-offset-gray-900 focus:ring-2 cursor-pointer">
                        <span class="text-sm select-none">Recordarme</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-orange-400 hover:text-blue-300 hover:underline transition duration-200">¿Primera vez o olvidaste tu contraseña?</a>
                </div>
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-500 hover:to-red-500 text-white font-bold py-3.5 px-4 rounded-2xl shadow-xl shadow-orange-500/10 hover:shadow-orange-500/20 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                            Ingresar a la Plataforma
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Iniciando sesión...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
