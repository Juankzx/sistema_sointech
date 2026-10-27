<div class="max-w-6xl mx-auto space-y-6 pb-20" x-data="{ activeTab: @entangle('activeTab') }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Configuración del Sistema</h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Personaliza la identidad del taller, facturación, garantías, listas de control y canales de comunicación.</p>
        </div>
    </div>

    <!-- Tab Bar -->
    <div class="flex items-center gap-1.5 p-1 rounded-xl bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 overflow-x-auto scrollbar-thin">
        <button type="button" @click="activeTab = 'general'" 
            :class="activeTab === 'general' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="building-2" class="w-4 h-4 text-zinc-500" />
            <span>Empresa</span>
        </button>
        <button type="button" @click="activeTab = 'sii'" 
            :class="activeTab === 'sii' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="landmark" class="w-4 h-4 text-zinc-500" />
            <span>Facturación / SII</span>
        </button>
        <button type="button" @click="activeTab = 'warranty'" 
            :class="activeTab === 'warranty' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="file-text" class="w-4 h-4 text-zinc-500" />
            <span>Garantía Legal</span>
        </button>
        <button type="button" @click="activeTab = 'checklist'" 
            :class="activeTab === 'checklist' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="check-circle" class="w-4 h-4 text-zinc-500" />
            <span>Checklists</span>
        </button>
        <button type="button" @click="activeTab = 'catalog'" 
            :class="activeTab === 'catalog' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="smartphone" class="w-4 h-4 text-zinc-500" />
            <span>Catálogo Predictivo</span>
        </button>
        <button type="button" @click="activeTab = 'smtp'" 
            :class="activeTab === 'smtp' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="mail" class="w-4 h-4 text-zinc-500" />
            <span>Servidor SMTP</span>
        </button>
        <button type="button" @click="activeTab = 'templates'" 
            :class="activeTab === 'templates' ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="file-code" class="w-4 h-4 text-zinc-500" />
            <span>Plantillas de Correo</span>
        </button>
        <button type="button" @click="activeTab = 'whatsapp'" 
            :class="activeTab === 'whatsapp' ? 'bg-white dark:bg-zinc-800 text-emerald-600 dark:text-emerald-400 shadow-sm border border-zinc-200/80 dark:border-zinc-700/80' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'" 
            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition cursor-pointer">
            <x-ui.icon name="whatsapp" class="w-4 h-4 text-emerald-500" />
            <span>WhatsApp Cloud API</span>
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5 animate-fade-in">
            <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-3.5 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 text-red-800 dark:text-red-300 text-xs flex items-center gap-2.5 animate-fade-in">
            <x-ui.icon name="alert-triangle" class="w-4 h-4 text-red-600 dark:text-red-400 shrink-0" />
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- TAB 0: EMPRESA Y GENERAL -->
    <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="building-2" class="w-5 h-5 text-zinc-500" />
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Identidad del Taller y Contacto</h2>
                </div>
            </div>

            <form wire:submit.prevent="saveCompanySettings" class="p-5 sm:p-6 space-y-6">
                <!-- Identidad Visual -->
                <div>
                    <h3 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-4 pb-1 border-b border-zinc-200 dark:border-zinc-800">Identidad Visual</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Logotipo Principal</label>
                            <div class="flex items-center gap-4 mb-2">
                                @if($logo_path && !$new_logo)
                                    <img src="{{ Storage::url($logo_path) }}" class="w-14 h-14 object-cover rounded-xl border border-zinc-200 dark:border-zinc-700">
                                @elseif($new_logo)
                                    <img src="{{ $new_logo->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-xl border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="w-14 h-14 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center text-zinc-400">
                                        <x-ui.icon name="image" class="w-6 h-6" />
                                    </div>
                                @endif
                            </div>
                            <input type="file" wire:model="new_logo" accept="image/*" class="w-full text-xs text-zinc-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-zinc-100 dark:file:bg-zinc-800 file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700 cursor-pointer">
                            @error('new_logo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Favicon (Navegador)</label>
                            <div class="flex items-center gap-4 mb-2">
                                @if($favicon_path && !$new_favicon)
                                    <img src="{{ Storage::url($favicon_path) }}" class="h-8 object-contain rounded p-1 bg-white border border-zinc-200 dark:border-zinc-700">
                                @elseif($new_favicon)
                                    <img src="{{ $new_favicon->temporaryUrl() }}" class="h-8 object-contain rounded p-1 bg-white border border-zinc-200 dark:border-zinc-700">
                                @else
                                    <div class="h-8 w-8 rounded border border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center text-zinc-400">
                                        <x-ui.icon name="globe" class="w-4 h-4" />
                                    </div>
                                @endif
                            </div>
                            <input type="file" wire:model="new_favicon" accept="image/*" class="w-full text-xs text-zinc-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-zinc-100 dark:file:bg-zinc-800 file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700 cursor-pointer">
                            @error('new_favicon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nombre Comercial (Fantasía)</label>
                            <input type="text" wire:model="trade_name" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Sointech">
                            @error('trade_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Contacto Público -->
                <div>
                    <h3 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-4 pb-1 border-b border-zinc-200 dark:border-zinc-800">Información de Contacto</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Dirección Física</label>
                            <input type="text" wire:model="company_address" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Av. Providencia 1234, Local 5, Santiago">
                            @error('company_address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Teléfono Base</label>
                            <input type="text" wire:model="company_phone" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: +56 2 2123 4567">
                            @error('company_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">WhatsApp de Soporte</label>
                            <input type="text" wire:model="support_whatsapp" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: +56912345678">
                            @error('support_whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Email de Soporte</label>
                            <input type="email" wire:model="support_email" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: contacto@taller.cl">
                            @error('support_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Instagram (Usuario)</label>
                            <input type="text" wire:model="social_instagram" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: @sointech">
                            @error('social_instagram') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración Regional -->
                <div>
                    <h3 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-4 pb-1 border-b border-zinc-200 dark:border-zinc-800">Ajustes Regionales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Zona Horaria</label>
                            <select wire:model="timezone" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                                <option value="America/Santiago">America/Santiago</option>
                                <option value="America/Bogota">America/Bogota</option>
                                <option value="America/Lima">America/Lima</option>
                                <option value="America/Mexico_City">America/Mexico_City</option>
                                <option value="America/Argentina/Buenos_Aires">America/Buenos_Aires</option>
                                <option value="Europe/Madrid">Europe/Madrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Moneda del Sistema</label>
                            <select wire:model="currency" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                                <option value="CLP">Peso Chileno ($)</option>
                                <option value="USD">Dólar (US$)</option>
                                <option value="EUR">Euro (€)</option>
                                <option value="MXN">Peso Mexicano ($)</option>
                                <option value="COP">Peso Colombiano ($)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Tasa de Impuesto (%)</label>
                            <input type="number" step="0.1" wire:model="tax_rate" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: 19">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Configuración General
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <!-- TAB 1: SII Y FACTURACIÓN -->
    <div x-show="activeTab === 'sii'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="landmark" class="w-5 h-5 text-zinc-500" />
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Facturación y Datos Tributarios SII</h2>
                </div>
            </div>

            <form wire:submit.prevent="saveCompanySettings" class="p-5 sm:p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Razón Social</label>
                        <input type="text" wire:model="company_name" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Servicios Informáticos SPA">
                        @error('company_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">RUT Empresa</label>
                        <input type="text" wire:model="company_rut" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: 76.123.456-7">
                        @error('company_rut') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Giro Comercial</label>
                        <input type="text" wire:model="company_giro" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Reparación y mantenimiento informático">
                        @error('company_giro') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Código Actividad SII</label>
                        <input type="text" wire:model="company_activity_code" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: 952100">
                        @error('company_activity_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Ambiente SII</label>
                        <select wire:model="sii_environment" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                            <option value="certificacion">Ambiente de Certificación (Pruebas)</option>
                            <option value="produccion">Ambiente de Producción (Real)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">API Key SII</label>
                        <input type="password" wire:model="sii_api_key" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="••••••••••••••••">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Datos SII
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <!-- TAB 2: GARANTÍA LEGAL -->
    <div x-show="activeTab === 'warranty'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="file-text" class="w-5 h-5 text-zinc-500" />
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Condiciones del Contrato de Servicio y Garantía</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Texto impreso al pie de comprobantes PDF y acuerdos firmados digitalmente.</p>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="saveWarranty" class="p-5 sm:p-6 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Términos de la Garantía</label>
                        <textarea wire:model="warranty_text" rows="12" class="w-full px-3.5 py-3 text-xs font-mono leading-relaxed rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Redacta las cláusulas legales y coberturas aquí..."></textarea>
                        @error('warranty_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/60 dark:bg-zinc-900/50 p-4 flex flex-col">
                        <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                            <x-ui.icon name="eye" class="w-3.5 h-3.5" />
                            Vista Previa en Documento
                        </span>
                        <div class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-line overflow-y-auto max-h-96 pr-2 scrollbar-thin">
                            {{ $warranty_text ?: 'Sin términos configurados.' }}
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Términos Legales
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <!-- TAB 3: CHECKLISTS DE INGRESO -->
    <div x-show="activeTab === 'checklist'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-cloak>
        <!-- Categories list -->
        <x-ui.card class="p-4 space-y-2 h-fit">
            <span class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider px-2 block mb-1">Categorías de Dispositivos</span>
            @php
                $catLabels = [
                    'smartphone' => ['Smartphone / Móvil', 'smartphone'],
                    'smartwatch' => ['Smartwatch / Reloj', 'watch'],
                    'allinone' => ['All-in-One / iMac', 'monitor'],
                    'notebook' => ['Notebook / Laptop', 'laptop'],
                    'console' => ['Consola de Videojuegos', 'gamepad-2'],
                    'tablet' => ['Tablet / iPad', 'tablet'],
                    'other' => ['Otros Equipos', 'wrench'],
                ];
            @endphp
            @foreach($catLabels as $key => [$label, $iconName])
                <button type="button" wire:click="$set('selected_category', '{{ $key }}')" 
                    class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-medium flex items-center justify-between transition cursor-pointer {{ $selected_category === $key ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-semibold' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50' }}">
                    <span class="flex items-center gap-2">
                        <x-ui.icon name="{{ $iconName }}" class="w-4 h-4 text-zinc-500" />
                        {{ $label }}
                    </span>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-zinc-200/80 dark:bg-zinc-700/80 text-zinc-700 dark:text-zinc-300">
                        {{ count($checklist_templates[$key] ?? []) }}
                    </span>
                </button>
            @endforeach
        </x-ui.card>

        <!-- Category Items Editor -->
        <x-ui.card class="lg:col-span-2">
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <span>Puntos de Control:</span>
                        <span class="text-brand-500 font-bold capitalize">{{ $selected_category }}</span>
                    </h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Elementos que el técnico verificará durante el check-in.</p>
                </div>
            </div>

            <div class="p-5 sm:p-6 space-y-6">
                <!-- Add item form -->
                <form wire:submit.prevent="addChecklistItem" class="flex gap-2">
                    <input type="text" wire:model="new_checklist_item" class="flex-1 px-3 py-2 text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Parlantes, Wi-Fi, Lector SIM, Pantalla táctil...">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer shrink-0">
                        <x-ui.icon name="plus" class="w-4 h-4" />
                        Añadir
                    </button>
                </form>
                @error('new_checklist_item') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                <!-- Items list -->
                <div class="space-y-2">
                    <span class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider block">Ítems Activos</span>
                    @if(count($checklist_templates[$selected_category] ?? []) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($checklist_templates[$selected_category] as $index => $item)
                                <div class="p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 flex items-center justify-between group hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                                    <div class="flex items-center gap-2.5 truncate">
                                        <span class="w-5 h-5 rounded-md bg-zinc-200/80 dark:bg-zinc-800 text-[10px] font-bold text-zinc-600 dark:text-zinc-400 flex items-center justify-center shrink-0">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="text-xs text-zinc-800 dark:text-zinc-200 truncate">{{ $item }}</span>
                                    </div>
                                    <button type="button" wire:click="deleteChecklistItem({{ $index }})" class="p-1 text-zinc-400 hover:text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition opacity-70 group-hover:opacity-100" title="Eliminar ítem">
                                        <x-ui.icon name="trash-2" class="w-4 h-4" />
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-zinc-400 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 text-xs">
                            No hay ítems configurados en el checklist para esta categoría.
                        </div>
                    @endif
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- TAB 4: CATÁLOGO PREDICTIVO -->
    <div x-show="activeTab === 'catalog'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-cloak>
        <!-- Formulario para agregar equipo al catálogo -->
        <x-ui.card class="p-5 space-y-4 h-fit">
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Agregar Equipo</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Registra modelos en el autocompletado de ingreso.</p>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">Categoría</label>
                    <select wire:model.live="catalog_category" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="smartphone">Smartphone / Celular</option>
                        <option value="smartwatch">Smartwatch / Reloj</option>
                        <option value="allinone">All-in-One / iMac</option>
                        <option value="notebook">Notebook / Laptop</option>
                        <option value="desktop">PC de Escritorio</option>
                        <option value="tablet">Tablet / iPad</option>
                        <option value="console">Consola de Videojuegos</option>
                        <option value="other">Otro Tipo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">Marca</label>
                    <input type="text" wire:model="new_brand" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: Apple, Dell, Sony">
                    @error('new_brand') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">Modelo</label>
                    <input type="text" wire:model="new_model" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: iPhone 15 Pro, Inspiron 15">
                    @error('new_model') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="button" wire:click="addDeviceToCatalog" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Añadir al Catálogo
                </button>
            </div>
        </x-ui.card>

        <!-- Listado y Buscador -->
        <x-ui.card class="lg:col-span-2">
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                    Catálogo Registrado
                </h3>
                <div class="relative w-full sm:w-64">
                    <x-ui.icon name="search" class="w-3.5 h-3.5 text-zinc-400 absolute left-3 top-2.5" />
                    <input type="text" wire:model.live.debounce.300ms="catalog_search" class="w-full pl-9 pr-3 py-1.5 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Buscar marca o modelo...">
                </div>
            </div>

            <div class="p-5">
                @if(count($devices) > 0)
                    <!-- Desktop Table -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase text-[10px]">
                                    <th class="py-2.5 px-3">ID</th>
                                    <th class="py-2.5 px-3">Marca</th>
                                    <th class="py-2.5 px-3">Modelo</th>
                                    <th class="py-2.5 px-3 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                                @foreach($devices as $dev)
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-850/50 transition">
                                        <td class="py-2.5 px-3 font-mono text-zinc-400">#{{ $dev->id }}</td>
                                        <td class="py-2.5 px-3 font-semibold text-zinc-900 dark:text-zinc-100">{{ $dev->brand }}</td>
                                        <td class="py-2.5 px-3 text-zinc-600 dark:text-zinc-400">{{ $dev->model }}</td>
                                        <td class="py-2.5 px-3 text-right">
                                            <button type="button" wire:click="deleteDeviceFromCatalog({{ $dev->id }})" class="p-1 text-zinc-400 hover:text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition" title="Eliminar">
                                                <x-ui.icon name="trash-2" class="w-3.5 h-3.5" />
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="sm:hidden space-y-2">
                        @foreach($devices as $dev)
                            <div class="p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ $dev->brand }}</div>
                                    <div class="text-xs text-zinc-500">{{ $dev->model }}</div>
                                </div>
                                <button type="button" wire:click="deleteDeviceFromCatalog({{ $dev->id }})" class="p-1.5 text-zinc-400 hover:text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                                    <x-ui.icon name="trash-2" class="w-4 h-4" />
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $devices->links() }}
                    </div>
                @else
                    <div class="text-center py-10 text-zinc-400 text-xs">
                        No se encontraron equipos registrados en esta categoría.
                    </div>
                @endif
            </div>
        </x-ui.card>
    </div>

    <!-- TAB 5: SERVIDOR SMTP -->
    <div x-show="activeTab === 'smtp'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="mail" class="w-5 h-5 text-zinc-500" />
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Configuración del Servidor SMTP</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Credenciales para envío de notificaciones por correo a clientes y administradores.</p>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="saveSmtpSettings" class="p-5 sm:p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Host SMTP *</label>
                        <input type="text" wire:model="smtp_host" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: smtp.gmail.com">
                        @error('smtp_host') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Puerto *</label>
                        <input type="number" wire:model="smtp_port" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="587">
                        @error('smtp_port') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Encriptación</label>
                        <select wire:model="smtp_encryption" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                            <option value="tls">TLS (Puerto 587)</option>
                            <option value="ssl">SSL (Puerto 465)</option>
                            <option value="null">Ninguna</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Usuario SMTP</label>
                        <input type="text" wire:model="smtp_username" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="contacto@taller.cl">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Contraseña SMTP</label>
                        <input type="password" wire:model="smtp_password" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="••••••••">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Correo Remitente</label>
                        <input type="email" wire:model="smtp_from_address" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="no-reply@taller.cl">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nombre Remitente</label>
                        <input type="text" wire:model="smtp_from_name" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Sointech Soporte">
                    </div>
                </div>

                <!-- Notificaciones Automáticas -->
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-3">
                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 block">Notificaciones Automáticas</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 cursor-pointer">
                            <input type="checkbox" wire:model="notify_on_ot_status" class="mt-0.5 rounded border-zinc-300 text-brand-500 focus:ring-brand-500">
                            <div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block">Cambios de Estado en OT</span>
                                <span class="text-[11px] text-zinc-500">Notificar al cliente cuando su equipo cambie de estado.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 cursor-pointer">
                            <input type="checkbox" wire:model="notify_on_low_stock" class="mt-0.5 rounded border-zinc-300 text-brand-500 focus:ring-brand-500">
                            <div>
                                <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block">Alerta de Stock Bajo</span>
                                <span class="text-[11px] text-zinc-500">Avisar al administrador cuando un insumo llegue a stock mínimo.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Configuración SMTP
                    </button>
                </div>
            </form>

            <!-- Test Mail Section -->
            <div class="p-5 sm:p-6 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/40 dark:bg-zinc-900/40 space-y-3">
                <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 block">Probar Envío de Correo</span>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 max-w-lg">
                    <input type="email" wire:model="test_email_recipient" class="flex-1 px-3 py-2 text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="correo@ejemplo.cl">
                    <button type="button" wire:click="sendTestEmail" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs font-medium text-zinc-700 dark:text-zinc-200 bg-zinc-200/80 dark:bg-zinc-800 hover:bg-zinc-300 dark:hover:bg-zinc-700 transition cursor-pointer shrink-0">
                        <x-ui.icon name="send" class="w-3.5 h-3.5" />
                        Enviar Prueba
                    </button>
                </div>
                @error('test_email_recipient') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
            </div>
        </x-ui.card>
    </div>

    <!-- TAB 6: PLANTILLAS DE CORREO -->
    <div x-show="activeTab === 'templates'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="file-code" class="w-5 h-5 text-zinc-500" />
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Personalización de Plantillas de Correo</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Define los textos automáticos con variables dinámicas.</p>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="saveEmailTemplates" class="p-5 sm:p-6 space-y-6">
                <!-- OT Status Template -->
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">Plantilla: Cambio de Estado OT</span>
                        <button type="button" wire:click="resetEmailTemplate('ot')" class="text-xs text-brand-500 hover:underline">Restablecer por Defecto</button>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 mb-1">Asunto</label>
                        <input type="text" wire:model="email_ot_subject" class="w-full px-3 py-1.5 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 mb-1">Cuerpo del Mensaje</label>
                        <textarea wire:model="email_ot_body" rows="4" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"></textarea>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <span class="text-[10px] text-zinc-400 self-center">Variables:</span>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{nombre_cliente}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{codigo_ot}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{nuevo_estado}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{equipo}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{link_seguimiento}</code>
                    </div>
                </div>

                <!-- Low Stock Template -->
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">Plantilla: Alerta Stock Bajo</span>
                        <button type="button" wire:click="resetEmailTemplate('low_stock')" class="text-xs text-brand-500 hover:underline">Restablecer por Defecto</button>
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 mb-1">Asunto</label>
                        <input type="text" wire:model="email_low_stock_subject" class="w-full px-3 py-1.5 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-zinc-600 dark:text-zinc-400 mb-1">Cuerpo del Mensaje</label>
                        <textarea wire:model="email_low_stock_body" rows="4" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"></textarea>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <span class="text-[10px] text-zinc-400 self-center">Variables:</span>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{producto}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{stock_actual}</code>
                        <code class="px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] text-zinc-700 dark:text-zinc-300">{stock_minimo}</code>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Plantillas
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <!-- TAB 7: WHATSAPP CLOUD API -->
    <div x-show="activeTab === 'whatsapp'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6" x-cloak>
        <x-ui.card>
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <x-ui.icon name="message-circle" class="w-5 h-5 text-emerald-500" />
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">WhatsApp Cloud API (Meta Oficial)</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Notificaciones automáticas directas al número de teléfono del cliente.</p>
                    </div>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $whatsapp_enabled ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 border-zinc-200 dark:border-zinc-700' }}">
                    {{ $whatsapp_enabled ? 'Activo' : 'Desactivado' }}
                </span>
            </div>

            <form wire:submit.prevent="saveCompanySettings" class="p-5 sm:p-6 space-y-6">
                <div class="flex items-center justify-between p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <div>
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block">Habilitar Notificaciones de WhatsApp</span>
                        <span class="text-[11px] text-zinc-500">Enviar aviso al ingresar y actualizar el estado de una orden.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="whatsapp_enabled" class="sr-only peer">
                        <div class="w-10 h-5 bg-zinc-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Phone Number ID *</label>
                        <input type="text" wire:model="whatsapp_phone_number_id" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: 102938475610293">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">WhatsApp Business Account ID *</label>
                        <input type="text" wire:model="whatsapp_business_account_id" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Ej: 987654321012345">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Token de Acceso Permanente (Bearer Token) *</label>
                        <textarea wire:model="whatsapp_access_token" rows="2" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="EAAA..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nombre de Plantilla en Meta</label>
                        <input type="text" wire:model="whatsapp_template_name" class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="ot_status_update">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Probar Conexión WhatsApp</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="test_whatsapp_recipient" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="+56912345678">
                            <button type="button" wire:click="sendTestWhatsApp" class="px-3.5 py-2 rounded-xl text-xs font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition cursor-pointer shrink-0">
                                Probar
                            </button>
                        </div>
                    </div>
                </div>

                @if(session()->has('whatsapp_test_success'))
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold block">{{ session('whatsapp_test_success') }}</span>
                @endif
                @if(session()->has('whatsapp_test_error'))
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold block">{{ session('whatsapp_test_error') }}</span>
                @endif

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-medium text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition cursor-pointer">
                        <x-ui.icon name="check" class="w-4 h-4" />
                        Guardar Configuración Meta WhatsApp
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>
