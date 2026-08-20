<div class="max-w-6xl mx-auto pb-20" x-data="{ activeTab: @entangle('activeTab') }">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 border-b border-gray-800 pb-4">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Configuración del Sistema</h2>
            <p class="text-sm text-gray-400 mt-1">Personaliza las condiciones legales, listas de chequeo técnico y el catálogo predictivo de ingreso de equipos.</p>
        </div>
        <div class="flex flex-wrap gap-2 bg-gray-950 p-1.5 rounded-2xl border border-gray-800">
            <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                🏢 Empresa y Contacto
            </button>
            <button @click="activeTab = 'sii'" :class="activeTab === 'sii' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                🏛️ Facturación y SII
            </button>
            <button @click="activeTab = 'warranty'" :class="activeTab === 'warranty' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                📄 Garantía Legal
            </button>
            <button @click="activeTab = 'checklist'" :class="activeTab === 'checklist' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                ✅ Checklists
            </button>
            <button @click="activeTab = 'services'" :class="activeTab === 'services' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                🛠️ Servicios
            </button>
            <button @click="activeTab = 'catalog'" :class="activeTab === 'catalog' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                📱 Catálogo
            </button>
            <button @click="activeTab = 'smtp'" :class="activeTab === 'smtp' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                ⚙️ Servidor SMTP
            </button>
            <button @click="activeTab = 'templates'" :class="activeTab === 'templates' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                📝 Plantillas de Correo
            </button>
        </div>
    </div>

    <!-- Mensajes de Alerta -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-950/50 border border-green-500/30 text-green-300 px-5 py-4 rounded-2xl relative shadow-lg shadow-green-500/5 flex items-center gap-3 animate-fade-in" role="alert">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-ping"></span>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-950/50 border border-red-500/30 text-red-300 px-5 py-4 rounded-2xl relative shadow-lg shadow-red-500/5 flex items-center gap-3 animate-fade-in" role="alert">
            <span class="w-2 h-2 rounded-full bg-red-400 animate-ping"></span>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- TAB 0: GENERAL Y EMPRESA -->
    <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" x-cloak>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="text-base font-bold text-white">Identidad de la Empresa y Contacto</h3>
                </div>
            </div>
            <form wire:submit.prevent="saveCompanySettings" class="p-6 space-y-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- SECCIÓN 1: IDENTIDAD VISUAL -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-gray-700 pb-2">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Identidad Visual
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Logotipo Principal</label>
                            @if($logo_path && !$new_logo)
                                <img src="{{ Storage::url($logo_path) }}" class="w-16 h-16 object-cover rounded-full shadow-lg border border-gray-700 mb-3">
                            @elseif($new_logo)
                                <img src="{{ $new_logo->temporaryUrl() }}" class="w-16 h-16 object-cover rounded-full shadow-lg border border-gray-700 mb-3">
                            @endif
                            <input type="file" wire:model="new_logo" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                            @error('new_logo') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Favicon (Ícono Navegador)</label>
                            @if($favicon_path && !$new_favicon)
                                <img src="{{ Storage::url($favicon_path) }}" class="h-8 mb-3 bg-white p-1 rounded">
                            @elseif($new_favicon)
                                <img src="{{ $new_favicon->temporaryUrl() }}" class="h-8 mb-3 bg-white p-1 rounded">
                            @endif
                            <input type="file" wire:model="new_favicon" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                            @error('new_favicon') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre Comercial (Fantasía)</label>
                            <input type="text" wire:model="trade_name" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: FixTech Repairs">
                            @error('trade_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: CONTACTO PÚBLICO -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-gray-700 pb-2">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Información de Contacto (Pública)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Dirección Física</label>
                            <input type="text" wire:model="company_address" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Av. Providencia 1234, Local 5, Santiago">
                            @error('company_address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono Base</label>
                            <input type="text" wire:model="company_phone" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: +56 2 2123 4567">
                            @error('company_phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">WhatsApp de Soporte</label>
                            <input type="text" wire:model="support_whatsapp" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: +56912345678 (Sin espacios)">
                            @error('support_whatsapp') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email de Soporte</label>
                            <input type="email" wire:model="support_email" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: contacto@taller.com">
                            @error('support_email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Instagram (Usuario)</label>
                            <input type="text" wire:model="social_instagram" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: @mitaller">
                            @error('social_instagram') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN: CONFIGURACIÓN REGIONAL -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-gray-700 pb-2">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ajustes Regionales
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Zona Horaria</label>
                            <select wire:model="timezone" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="America/Santiago">America/Santiago</option>
                                <option value="America/Bogota">America/Bogota</option>
                                <option value="America/Lima">America/Lima</option>
                                <option value="America/Mexico_City">America/Mexico_City</option>
                                <option value="America/Argentina/Buenos_Aires">America/Buenos_Aires</option>
                                <option value="Europe/Madrid">Europe/Madrid</option>
                            </select>
                            @error('timezone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Moneda del Sistema</label>
                            <select wire:model="currency" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="CLP">Peso Chileno ($)</option>
                                <option value="USD">Dólar (US$)</option>
                                <option value="EUR">Euro (€)</option>
                                <option value="MXN">Peso Mexicano ($)</option>
                                <option value="COP">Peso Colombiano ($)</option>
                            </select>
                            @error('currency') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tasa de Impuesto (%)</label>
                            <input type="number" step="0.1" wire:model="tax_rate" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 19">
                            @error('tax_rate') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-700 mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-6 py-3 rounded-2xl text-sm transition-all duration-200 flex items-center gap-2 shadow-lg shadow-blue-500/10 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar General
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 1.5: FACTURACIÓN Y SII -->
    <div x-show="activeTab === 'sii'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" x-cloak>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-base font-bold text-white">Facturación y Datos Legales</h3>
                </div>
            </div>
            <form wire:submit.prevent="saveCompanySettings" class="p-6 space-y-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- SECCIÓN 2: DATOS LEGALES Y SII -->
                <div>
                    <h4 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-gray-700 pb-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Datos Legales / SII
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Razón Social</label>
                            <input type="text" wire:model="company_name" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Servicios Integrales SPA">
                            @error('company_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">RUT Empresa</label>
                            <input type="text" wire:model="company_rut" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 76.123.456-7">
                            @error('company_rut') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Giro (Actividad Comercial)</label>
                            <input type="text" wire:model="company_giro" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Reparación de Equipos Electrónicos">
                            @error('company_giro') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Código Actividad SII</label>
                            <input type="text" wire:model="company_activity_code" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 952100">
                            @error('company_activity_code') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Ambiente SII</label>
                            <select wire:model="sii_environment" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="certificacion">Ambiente de Certificación (Pruebas)</option>
                                <option value="produccion">Ambiente de Producción (Real)</option>
                            </select>
                            @error('sii_environment') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">API Key SII</label>
                            <input type="password" wire:model="sii_api_key" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••••••••••">
                            @error('sii_api_key') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>



                <div class="flex justify-end pt-4 border-t border-gray-700 mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-6 py-3 rounded-2xl text-sm transition-all duration-200 flex items-center gap-2 shadow-lg shadow-blue-500/10 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar SII
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 1: GARANTÍA LEGAL -->
    <div x-show="activeTab === 'warranty'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" x-cloak>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-base font-bold text-white">Condiciones del Contrato de Servicio y Garantía</h3>
                </div>
            </div>
            <form wire:submit.prevent="saveWarranty" class="p-6 space-y-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-300">Términos de la Garantía</label>
                    <p class="text-xs text-gray-400 mb-3">Este texto aparecerá al pie del recibo físico en PDF del cliente y en los documentos digitales firmados. Debe detallar claramente la cobertura y plazos para proteger legalmente a tu taller ante reclamos indebidos.</p>
                    <textarea wire:model="warranty_text" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-4 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-sans leading-relaxed" rows="12" placeholder="Redacta los términos y cláusulas legales aquí..."></textarea>
                    @error('warranty_text') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="bg-blue-950/20 border border-blue-800/30 p-5 rounded-2xl flex flex-col">
                    <h4 class="text-xs font-black text-blue-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Vista Previa en Documento Impreso
                    </h4>
                    <div class="text-xs text-gray-300 italic leading-relaxed font-sans bg-gray-900/60 p-4 rounded-xl border border-gray-800 whitespace-pre-line overflow-y-auto max-h-96 scrollbar-thin scrollbar-thumb-gray-700">
                        {{ $warranty_text ?: 'Garantía del servicio no configurada aún.' }}
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-6 py-3 rounded-2xl text-sm transition-all duration-200 flex items-center gap-2 shadow-lg shadow-blue-500/10 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Términos Legales
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 2: CHECKLISTS DE INGRESO -->
    <div x-show="activeTab === 'checklist'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar de Categorías -->
        <div class="bg-gray-800 rounded-3xl p-5 border border-gray-700 space-y-3">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-2 px-2">Categorías de Equipos</h4>
            <div class="space-y-1.5">
                <button wire:click="$set('selected_category', 'smartphone')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'smartphone' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>📱 Smartphone</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['smartphone'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'smartwatch')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'smartwatch' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>⌚ Smartwatch</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['smartwatch'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'allinone')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'allinone' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>🖥️ All-in-One / iMac</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['allinone'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'notebook')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'notebook' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>💻 Notebook / PC</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['notebook'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'console')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'console' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>🎮 Consolas</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['console'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'tablet')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'tablet' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>📟 Tablets</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['tablet'] ?? []) }} ítems</span>
                </button>
                <button wire:click="$set('selected_category', 'other')" class="w-full text-left px-4 py-3 rounded-2xl text-sm font-bold flex items-center justify-between transition {{ $selected_category === 'other' ? 'bg-blue-600 text-white shadow' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                    <span>⚙️ Otros Equipos</span>
                    <span class="bg-gray-900/40 text-[10px] px-2 py-0.5 rounded-full">{{ count($checklist_templates['other'] ?? []) }} ítems</span>
                </button>
            </div>
        </div>

        <!-- Gestor de Ítems del Checklist -->
        <div class="lg:col-span-2 bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2 capitalize">
                    <span>Lista de Control:</span>
                    <span class="text-blue-400 font-black">{{ $selected_category }}</span>
                </h3>
                <span class="text-xs text-gray-400">Personaliza los chequeos rápidos en recepción</span>
            </div>

            <div class="p-6 space-y-6">
                <!-- Agregar nuevo ítem -->
                <form wire:submit.prevent="addChecklistItem" class="flex gap-2">
                    <input type="text" wire:model="new_checklist_item" class="flex-1 bg-gray-700 border border-gray-600 rounded-2xl px-4 py-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Parlantes, Wi-Fi, Lector de disco...">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 rounded-2xl text-sm font-bold flex items-center gap-1.5 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Añadir
                    </button>
                </form>
                @error('new_checklist_item') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror

                <!-- Lista de ítems activos -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Ítems a Revisar</h4>
                    
                    @if(count($checklist_templates[$selected_category] ?? []) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($checklist_templates[$selected_category] as $index => $item)
                                <div class="bg-gray-900/50 border border-gray-700/60 rounded-2xl p-4 flex items-center justify-between group hover:border-gray-600 transition-all duration-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 font-bold text-xs">
                                            {{ $index + 1 }}
                                        </div>
                                        <span class="text-sm text-gray-200 font-medium">{{ $item }}</span>
                                    </div>
                                    <button type="button" wire:click="deleteChecklistItem({{ $index }})" class="text-gray-500 hover:text-red-400 p-1.5 rounded-lg hover:bg-red-500/10 opacity-60 group-hover:opacity-100 transition-all duration-200" title="Eliminar ítem">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 bg-gray-900/30 rounded-2xl border border-dashed border-gray-700">
                            <svg class="w-8 h-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span class="text-xs">No hay ítems configurados en el checklist para esta categoría.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: CATÁLOGO PREDICTIVO -->
    <div x-show="activeTab === 'catalog'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario para agregar equipo al catálogo -->
        <div class="bg-gray-800 rounded-3xl p-6 border border-gray-700 space-y-5 h-fit">
            <div>
                <h4 class="text-base font-bold text-white">Agregar Equipo Estandarizado</h4>
                <p class="text-xs text-gray-400 mt-1">Registra equipos comerciales en el buscador predictivo para que salgan en los seeders autocompletables.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Categoría</label>
                    <select wire:model.live="catalog_category" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="smartphone">📱 Smartphone / Celular</option>
                        <option value="smartwatch">⌚ Smartwatch / Reloj Inteligente</option>
                        <option value="allinone">🖥️ PC All-in-One / iMac</option>
                        <option value="notebook">💻 Notebook / Laptop</option>
                        <option value="desktop">🖥️ PC de Escritorio (Torre)</option>
                        <option value="tablet">📟 Tablet / iPad</option>
                        <option value="console">🎮 Consola de Videojuegos</option>
                        <option value="other">⚙️ Otro Tipo / Especializado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Marca</label>
                    <input type="text" wire:model="new_brand" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Apple, Sony, Nintendo">
                    @error('new_brand') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Modelo</label>
                    <input type="text" wire:model="new_model" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: iPhone 15 Pro, PlayStation 5 Slim">
                    @error('new_model') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="button" wire:click="addDeviceToCatalog" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded-2xl text-xs transition duration-200 shadow-md shadow-blue-500/10 flex items-center justify-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Añadir al Catálogo Predictivo
                </button>
            </div>
        </div>

        <!-- Listado y Buscador del Catálogo Predictivo -->
        <div class="lg:col-span-2 bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <span>Catálogo:</span>
                        <span class="text-blue-400 font-black">
                            @switch($catalog_category)
                                @case('smartphone') Smartphones / Celulares @break
                                @case('smartwatch') Smartwatches / Relojes @break
                                @case('allinone') All-in-One / iMac @break
                                @case('notebook') Notebooks / Laptops @break
                                @case('desktop') PCs de Escritorio @break
                                @case('tablet') Tablets / iPads @break
                                @case('console') Consolas de Videojuegos @break
                                @default {{ ucfirst($catalog_category) }}s
                            @endswitch
                        </span>
                    </h3>
                </div>
                <div class="relative w-full md:w-64">
                    <input type="text" wire:model.live.debounce.300ms="catalog_search" class="w-full bg-gray-700 border border-gray-600 rounded-2xl pl-10 pr-4 py-2.5 text-white text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar marca o modelo...">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                </div>
            </div>

            <div class="p-6">
                <!-- Tabla de equipos -->
                @if(count($devices) > 0)
                    <!-- DESKTOP TABLE -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-300">
                            <thead class="bg-gray-900 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-700">
                                <tr>
                                    <th class="px-4 py-3 rounded-tl-xl">ID</th>
                                    <th class="px-4 py-3">Marca</th>
                                    <th class="px-4 py-3">Modelo</th>
                                    <th class="px-4 py-3 text-right rounded-tr-xl">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @foreach($devices as $dev)
                                    <tr class="hover:bg-gray-750/30 transition duration-150">
                                        <td class="px-4 py-3.5 font-bold text-xs text-gray-500">#{{ $dev->id }}</td>
                                        <td class="px-4 py-3.5 font-black text-white text-xs">{{ $dev->brand }}</td>
                                        <td class="px-4 py-3.5 text-xs font-semibold text-gray-300">{{ $dev->model }}</td>
                                        <td class="px-4 py-3.5 text-right">
                                            <button type="button" wire:click="deleteDeviceFromCatalog({{ $dev->id }})" class="text-gray-500 hover:text-red-400 p-1.5 rounded-lg hover:bg-red-500/10 transition" title="Eliminar equipo">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- MOBILE CARDS -->
                    <div class="md:hidden flex flex-col gap-3">
                        @foreach($devices as $dev)
                            <div class="bg-gray-750/30 border border-gray-700/50 rounded-2xl p-4 flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-[10px] text-gray-500">#{{ $dev->id }}</span>
                                        <span class="font-black text-white text-xs">{{ $dev->brand }}</span>
                                    </div>
                        <h4 class="text-sm font-bold text-gray-300">Catálogo Vacío</h4>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">No se encontraron marcas o modelos registrados en esta categoría que coincidan con tu búsqueda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- TAB 5: SERVIDOR DE CORREO SMTP Y NOTIFICACIONES -->
    <div x-show="activeTab === 'smtp'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" x-cloak>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <h3 class="text-base font-bold text-white">Configuración del Servidor de Correo (SMTP)</h3>
                </div>
            </div>

            <div class="p-6 space-y-8">
                <!-- FORMULARIO SMTP -->
                <form wire:submit.prevent="saveSmtpSettings" class="space-y-6">
                    <div class="bg-blue-950/30 border border-blue-800/40 rounded-2xl p-4 text-xs text-blue-200 flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong class="text-white block font-bold mb-0.5">Información sobre envíos de correo real:</strong>
                            Ingresa las credenciales de tu proveedor SMTP (Gmail, cPanel, Mailtrap, Zoho, SendGrid, etc.). Al guardar y probar, el sistema enviará correos reales a tus clientes sobre el estado de sus órdenes de trabajo y notificaciones de stock al administrador.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Servidor SMTP (Host) *</label>
                            <input type="text" wire:model="smtp_host" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: smtp.gmail.com o mail.tuempresa.cl">
                            @error('smtp_host') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Puerto SMTP *</label>
                            <input type="number" wire:model="smtp_port" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 587 o 465">
                            @error('smtp_port') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Encriptación</label>
                            <select wire:model="smtp_encryption" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="tls">TLS (Recomendado - Puerto 587)</option>
                                <option value="ssl">SSL (Puerto 465)</option>
                                <option value="null">Ninguna / Sin Encriptación</option>
                            </select>
                            @error('smtp_encryption') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Usuario SMTP (Correo Electrónico)</label>
                            <input type="text" wire:model="smtp_username" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: contacto@tuempresa.cl">
                            @error('smtp_username') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Contraseña SMTP / Clave de Aplicación</label>
                            <input type="password" wire:model="smtp_password" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••••••••••">
                            @error('smtp_password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Correo del Remitente (From Address)</label>
                            <input type="email" wire:model="smtp_from_address" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: no-reply@tuempresa.cl">
                            @error('smtp_from_address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre del Remitente (From Name)</label>
                            <input type="text" wire:model="smtp_from_name" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Soin Technology Soporte">
                            @error('smtp_from_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- PREFERENCIAS DE NOTIFICACIONES -->
                    <div class="pt-4 border-t border-gray-700/60 space-y-4">
                        <h4 class="text-xs font-bold text-gray-300 uppercase tracking-widest">Preferencia de Notificaciones Automáticas</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center gap-3 bg-gray-900/60 p-4 rounded-2xl border border-gray-700 cursor-pointer hover:bg-gray-900 transition">
                                <input type="checkbox" wire:model="notify_on_ot_status" class="w-5 h-5 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500">
                                <div>
                                    <strong class="text-sm font-bold text-white block">Notificar Cambios de Estado en OT</strong>
                                    <span class="text-xs text-gray-400">Enviar correo automático al cliente cuando su equipo cambie de estado.</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 bg-gray-900/60 p-4 rounded-2xl border border-gray-700 cursor-pointer hover:bg-gray-900 transition">
                                <input type="checkbox" wire:model="notify_on_low_stock" class="w-5 h-5 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500">
                                <div>
                                    <strong class="text-sm font-bold text-white block">Alerta de Stock Bajo en Inventario</strong>
                                    <span class="text-xs text-gray-400">Enviar correo al Administrador cuando un producto llegue a su stock mínimo.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-700 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-6 py-3 rounded-2xl shadow-lg shadow-blue-500/20 transition duration-150 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Guardar Configuración SMTP
                        </button>
                    </div>
                </form>

                <!-- PROBAR ENVÍO DE CORREO -->
                <div class="pt-8 border-t border-gray-700 space-y-4">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Probar Envío de Correo
                    </h4>
                    <p class="text-xs text-gray-400">Envía un correo de prueba en tiempo real a una casilla especificada para validar que las credenciales funcionen correctamente.</p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="email" wire:model="test_email_recipient" class="flex-1 bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="correo@ejemplo.com">
                        <button type="button" wire:click="sendTestEmail" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-6 py-3 rounded-2xl shadow-lg shadow-emerald-500/20 transition duration-150 flex items-center justify-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Enviar Correo de Prueba
                        </button>
                    </div>
                    @error('test_email_recipient') <span class="text-red-400 text-xs block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 7: PLANTILLAS DE CORREO -->
    <div x-show="activeTab === 'templates'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" x-cloak>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h3 class="text-base font-bold text-white">Personalización de Plantillas de Correo Electrónico</h3>
                </div>
            </div>

            <form wire:submit.prevent="saveEmailTemplates" class="p-6 space-y-8">
                <!-- PLANTILLA 1: ORDEN DE TRABAJO -->
                <div class="bg-gray-900/40 p-6 rounded-2xl border border-gray-700 space-y-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-gray-700/60 pb-3">
                        <div>
                            <h4 class="text-sm font-bold text-white flex items-center gap-2">
                                📌 Notificación de Cambio de Estado en Orden de Trabajo
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">Correo enviado al cliente cuando la orden pasa a Revisión, Presupuestado, Listo, Entregado, etc.</p>
                        </div>
                        <button type="button" wire:click="resetEmailTemplate('ot')" class="text-xs text-amber-400 hover:text-amber-300 font-semibold underline flex items-center gap-1">
                            ↺ Restablecer por Defecto
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Asunto del Correo</label>
                        <input type="text" wire:model="email_ot_subject" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email_ot_subject') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Mensaje / Cuerpo del Correo</label>
                        <textarea wire:model="email_ot_body" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono"></textarea>
                        @error('email_ot_body') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 space-y-2">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Variables Dinámicas Disponibles (se reemplazarán automáticamente):</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{nombre_cliente}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{codigo_ot}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{nuevo_estado}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{equipo}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{falla}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{link_seguimiento}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950/80 text-blue-300 text-xs font-mono border border-blue-800/60 font-semibold">{nombre_empresa}</span>
                        </div>
                    </div>
                </div>

                <!-- PLANTILLA 2: STOCK BAJO -->
                <div class="bg-gray-900/40 p-6 rounded-2xl border border-gray-700 space-y-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-gray-700/60 pb-3">
                        <div>
                            <h4 class="text-sm font-bold text-white flex items-center gap-2">
                                ⚠️ Alerta de Stock Bajo en Inventario
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">Correo interno enviado al Administrador cuando un repuesto o producto alcanza su nivel crítico de stock.</p>
                        </div>
                        <button type="button" wire:click="resetEmailTemplate('low_stock')" class="text-xs text-amber-400 hover:text-amber-300 font-semibold underline flex items-center gap-1">
                            ↺ Restablecer por Defecto
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Asunto del Correo</label>
                        <input type="text" wire:model="email_low_stock_subject" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email_low_stock_subject') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Mensaje / Cuerpo del Correo</label>
                        <textarea wire:model="email_low_stock_body" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded-2xl p-3 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono"></textarea>
                        @error('email_low_stock_body') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 space-y-2">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Variables Dinámicas Disponibles:</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-950/80 text-emerald-300 text-xs font-mono border border-emerald-800/60 font-semibold">{producto}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-950/80 text-emerald-300 text-xs font-mono border border-emerald-800/60 font-semibold">{stock_actual}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-950/80 text-emerald-300 text-xs font-mono border border-emerald-800/60 font-semibold">{stock_minimo}</span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-950/80 text-emerald-300 text-xs font-mono border border-emerald-800/60 font-semibold">{nombre_empresa}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-700 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-6 py-3 rounded-2xl shadow-lg shadow-blue-500/20 transition duration-150 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Plantillas de Correo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

