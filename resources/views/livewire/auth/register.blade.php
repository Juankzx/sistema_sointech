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
                    Alta de Operadores y Personal
                </div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    Únete al equipo técnico líder del sector.
                </h1>
                <p class="text-gray-400 text-base leading-relaxed">
                    Comienza a digitalizar la administración de reparaciones, soporte en tiempo real y el control de inventarios de Sointech.
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

    <!-- RIGHT SIDE: Elegant Register form (50% width on md+, 100% on mobile) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-8 md:px-16 bg-gray-955/90 relative">
        <!-- Tech detail circles -->
        <div class="absolute top-20 right-20 w-72 h-72 bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-purple-600/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="w-full max-w-md bg-gray-900/60 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-blue-500/30">
            <!-- Form Header -->
            <div class="flex flex-col items-center mb-6 relative">
                <!-- Logo shown on mobile layout -->
                <div class="md:hidden mb-4">
                    <img src="/images/logo-dark.png" class="h-12 w-auto object-contain" alt="Sointech Logo">
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight">Crear una Cuenta</h2>
                <p class="text-sm text-gray-400 mt-2">Completa los datos para registrarte como operador</p>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="register" class="space-y-4 relative">
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nombre Completo</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input wire:model="name" id="name" type="text" placeholder="Juan Pérez" 
                            class="w-full bg-gray-950/80 border border-gray-800 rounded-2xl py-3 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('name') 
                        <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Correo Electrónico</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input wire:model="email" id="email" type="email" placeholder="ejemplo@sointech.cl" 
                            class="w-full bg-gray-955/80 border border-gray-800 rounded-2xl py-3 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('email') 
                        <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Rol del Usuario</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </span>
                        <select wire:model="role" id="role" 
                            class="w-full bg-gray-950/80 border border-gray-800 rounded-2xl py-3 pl-11 pr-4 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner appearance-none cursor-pointer">
                            <option value="tecnico">Técnico</option>
                            <option value="recepcionista">Recepcionista</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    @error('role') 
                        <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Contraseña</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input wire:model="password" id="password" type="password" placeholder="••••••••" 
                            class="w-full bg-gray-955/80 border border-gray-800 rounded-2xl py-3 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner">
                    </div>
                    @error('password') 
                        <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Confirmar Contraseña</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 group-focus-within:text-blue-500 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" placeholder="••••••••" 
                            class="w-full bg-gray-955/80 border border-gray-800 rounded-2xl py-3 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition duration-200 shadow-inner">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3.5 px-4 rounded-2xl shadow-xl shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span wire:loading.remove wire:target="register" class="flex items-center gap-2">
                            Crear mi Cuenta
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="register" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creando cuenta...
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm border-t border-gray-800/80 pt-6 relative">
                <span class="text-gray-400">¿Ya tienes una cuenta?</span>
                <a href="/login" class="text-blue-500 hover:text-blue-400 font-bold ml-1 transition duration-200">Inicia sesión</a>
            </div>
        </div>
    </div>
</div>
