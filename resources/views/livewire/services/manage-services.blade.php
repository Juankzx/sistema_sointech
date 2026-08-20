<div class="max-w-7xl mx-auto pb-20 space-y-8">
    <!-- Header Principal del Módulo -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-800 pb-5">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="p-2.5 rounded-2xl bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Catálogo de Servicios</h2>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Gestión de precios base sugeridos y mano de obra técnica para el taller.</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1.5 rounded-2xl text-xs font-extrabold bg-indigo-950/80 text-indigo-300 border border-indigo-500/30 shadow-md">
                🛠️ {{ count($servicesList) }} Servicio(s) Catalogado(s)
            </span>
        </div>
    </div>

    <!-- Mensajes de Alerta -->
    @if (session()->has('message'))
        <div class="bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 px-5 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-fade-in" role="alert">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
            <span class="text-xs sm:text-sm font-bold">{{ session('message') }}</span>
        </div>
    @endif

    <!-- GRID PRINCIPAL: Formulario + Tabla de Servicios -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- COLUMNA 1: Formulario de Agregar / Editar -->
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700 h-fit">
            <div class="bg-gray-900/80 px-6 py-4 border-b border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $editing_service_id ? 'Editar Servicio' : 'Nuevo Servicio Frecuente' }}</span>
                </h3>
                @if($editing_service_id)
                    <button type="button" wire:click="cancelEdit" class="text-xs text-gray-400 hover:text-white underline cursor-pointer">
                        Cancelar
                    </button>
                @endif
            </div>
            
            <form wire:submit.prevent="saveService" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Nombre del Servicio *</label>
                    <input type="text" wire:model="service_name" placeholder="Ej: Mantenimiento Térmico Completo" class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-3.5 py-3 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition">
                    @error('service_name') <span class="text-red-400 text-xs font-semibold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Categoría de Dispositivo / Área *</label>
                    <select wire:model="service_category" class="w-full bg-gray-900 border border-gray-700 rounded-2xl px-3.5 py-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition cursor-pointer">
                        <option value="general">⚙️ General / Diagnóstico</option>
                        <option value="smartphone">📱 Smartphones / Celulares</option>
                        <option value="notebook">💻 Notebooks / Laptops</option>
                        <option value="console">🎮 Consolas de Videojuegos</option>
                        <option value="tablet">📟 Tablets / iPads</option>
                        <option value="smartwatch">⌚ Smartwatches / Relojes</option>
                        <option value="allinone">🖥️ All-in-One / Mac</option>
                        <option value="microsoldering">🔬 Micro-soldadura / Electrónica</option>
                        <option value="software">💻 Software / Optimización</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Precio Base Sugerido (CLP) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 font-bold">$</span>
                        <input type="number" step="500" wire:model="service_default_price" placeholder="Ej: 25000" class="w-full bg-gray-900 border border-gray-700 rounded-2xl pl-8 pr-4 py-3 text-xs text-white font-bold focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Este precio se sugerirá automáticamente en las OTs, pero el técnico podrá ajustarlo en cada caso.</p>
                    @error('service_default_price') <span class="text-red-400 text-xs font-semibold block mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Descripción u Observaciones</label>
                    <textarea wire:model="service_description" rows="3" placeholder="Detalla qué incluye esta labor técnica..." class="w-full bg-gray-900 border border-gray-700 rounded-2xl p-3.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-bold py-3.5 px-4 rounded-2xl text-xs shadow-lg shadow-indigo-500/25 transition cursor-pointer flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ $editing_service_id ? 'Guardar Cambios del Servicio' : 'Guardar Servicio en Catálogo' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- COLUMNA 2 & 3: Tabla y Buscador del Catálogo -->
        <div class="lg:col-span-2 bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-700">
            <div class="bg-gray-900/80 px-6 py-4 border-b border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <span>Listado de Servicios Catalogados</span>
                    </h3>
                </div>
                <div class="relative w-full sm:w-64">
                    <input type="text" wire:model.live.debounce.300ms="service_search" class="w-full bg-gray-700 border border-gray-600 rounded-2xl pl-9 pr-4 py-2 text-white text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400" placeholder="Buscar por nombre o categoría...">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if(count($servicesList) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-300">
                            <thead class="bg-gray-900 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-700">
                                <tr>
                                    <th class="px-4 py-3 rounded-tl-xl">Servicio</th>
                                    <th class="px-4 py-3">Categoría</th>
                                    <th class="px-4 py-3 text-right">Precio Sugerido</th>
                                    <th class="px-4 py-3 text-center">Estado</th>
                                    <th class="px-4 py-3 text-right rounded-tr-xl">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @foreach($servicesList as $srv)
                                    <tr class="hover:bg-gray-750/30 transition duration-150">
                                        <td class="px-4 py-3.5">
                                            <div class="font-bold text-white text-xs">{{ $srv->name }}</div>
                                            @if($srv->description)
                                                <div class="text-[10px] text-gray-400 truncate max-w-xs mt-0.5">{{ $srv->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-xs">
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-gray-900 text-gray-300 border border-gray-700">
                                                {{ $srv->category_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5 text-right font-black text-emerald-400 text-xs">
                                            ${{ number_format($srv->default_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <button type="button" wire:click="toggleStatus({{ $srv->id }})" class="cursor-pointer">
                                                @if($srv->is_active)
                                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-950/80 text-emerald-400 border border-emerald-500/30">Activo</span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase bg-gray-900 text-gray-500 border border-gray-700">Inactivo</span>
                                                @endif
                                            </button>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button type="button" wire:click="editService({{ $srv->id }})" class="text-indigo-400 hover:text-white p-1.5 rounded-lg hover:bg-indigo-950/50 transition cursor-pointer" title="Editar servicio">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button type="button" wire:click="deleteService({{ $srv->id }})" wire:confirm="¿Eliminar este servicio del catálogo?" class="text-gray-500 hover:text-red-400 p-1.5 rounded-lg hover:bg-red-500/10 transition cursor-pointer" title="Eliminar servicio">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500 bg-gray-900/30 rounded-3xl border border-dashed border-gray-700">
                        <svg class="w-10 h-10 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h4 class="text-sm font-bold text-gray-300">No Hay Servicios Catalogados</h4>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Usa el formulario de la izquierda para agregar el primer servicio técnico.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
