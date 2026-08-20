<div class="max-w-7xl mx-auto pb-20">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl font-black text-white tracking-tight">Catálogo de Servicios</h1>
            <p class="text-xs text-gray-500 mt-1">Precios base sugeridos para mano de obra técnica.</p>
        </div>
        <button wire:click="openCreateModal" class="flex items-center gap-2 bg-white text-gray-900 hover:bg-gray-100 font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Servicio
        </button>
    </div>

    {{-- FLASH --}}
    @if (session()->has('message'))
        <div class="mb-6 bg-emerald-950/50 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-xs font-bold flex items-center gap-2" x-data x-init="setTimeout(() => $el.remove(), 3000)">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- FILTERS BAR --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-6">
        {{-- Search --}}
        <div class="relative w-full sm:w-72">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar servicio..." class="w-full bg-gray-900 border border-gray-800 rounded-xl pl-10 pr-4 py-2.5 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-gray-600 transition">
        </div>

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-1.5">
            <button wire:click="setCategory('')" class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition cursor-pointer {{ $filterCategory === '' ? 'bg-white text-gray-900' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
                Todos <span class="ml-1 opacity-60">{{ $totalServices }}</span>
            </button>
            @foreach($categoryCounts as $cat => $count)
                @php
                    $catLabels = [
                        'general' => '⚙️ General',
                        'smartphone' => '📱 Smartphones',
                        'notebook' => '💻 Notebooks',
                        'console' => '🎮 Consolas',
                        'tablet' => '📟 Tablets',
                        'smartwatch' => '⌚ Smartwatches',
                        'allinone' => '🖥️ All-in-One',
                        'microsoldering' => '🔬 Micro-soldadura',
                        'software' => '💻 Software',
                    ];
                @endphp
                <button wire:click="setCategory('{{ $cat }}')" class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition cursor-pointer {{ $filterCategory === $cat ? 'bg-white text-gray-900' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
                    {{ $catLabels[$cat] ?? ucfirst($cat) }} <span class="ml-1 opacity-60">{{ $count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-2xl overflow-hidden">
        @if(count($services) > 0)
            {{-- Desktop Table --}}
            <div class="hidden md:block">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="text-left px-5 py-3.5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Servicio</th>
                            <th class="text-left px-5 py-3.5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Categoría</th>
                            <th class="text-right px-5 py-3.5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Precio Base</th>
                            <th class="text-center px-5 py-3.5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Estado</th>
                            <th class="text-right px-5 py-3.5 text-[10px] font-black text-gray-500 uppercase tracking-widest w-28"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60">
                        @foreach($services as $srv)
                            <tr class="group hover:bg-gray-800/30 transition duration-150">
                                <td class="px-5 py-4">
                                    <div class="text-sm font-bold text-white">{{ $srv->name }}</div>
                                    @if($srv->description)
                                        <div class="text-[11px] text-gray-500 mt-0.5 truncate max-w-sm">{{ $srv->description }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-[11px] font-bold text-gray-400">{{ $srv->category_label }}</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <span class="text-sm font-black text-white">${{ number_format($srv->default_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <button wire:click="toggleStatus({{ $srv->id }})" class="cursor-pointer">
                                        @if($srv->is_active)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-emerald-950/60 text-emerald-400 border border-emerald-500/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-gray-900 text-gray-500 border border-gray-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-600"></span> Inactivo
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if($confirmingDeleteId === $srv->id)
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button wire:click="deleteService({{ $srv->id }})" class="text-[10px] font-black text-red-400 bg-red-950/50 border border-red-500/30 px-2.5 py-1 rounded-lg hover:bg-red-950 transition cursor-pointer">Eliminar</button>
                                            <button wire:click="cancelDelete" class="text-[10px] font-bold text-gray-400 bg-gray-800 px-2.5 py-1 rounded-lg hover:text-white transition cursor-pointer">No</button>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <button wire:click="openEditModal({{ $srv->id }})" class="p-1.5 rounded-lg text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer" title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button wire:click="confirmDelete({{ $srv->id }})" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-950/30 transition cursor-pointer" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-gray-800/60">
                @foreach($services as $srv)
                    <div class="p-4 flex items-center justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-white truncate">{{ $srv->name }}</span>
                                @if($srv->is_active)
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-600 shrink-0"></span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-gray-500">
                                <span>{{ $srv->category_label }}</span>
                                <span>·</span>
                                <span class="font-black text-white">${{ number_format($srv->default_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button wire:click="openEditModal({{ $srv->id }})" class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $srv->id }})" class="p-2 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-950/30 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 px-6">
                <svg class="w-10 h-10 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <p class="text-sm font-bold text-gray-400">Sin resultados</p>
                <p class="text-xs text-gray-600 mt-1">No se encontraron servicios con los filtros actuales.</p>
            </div>
        @endif
    </div>

    {{-- CREATE/EDIT MODAL --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-init="document.body.classList.add('overflow-hidden')" x-on:remove="document.body.classList.remove('overflow-hidden')">
            {{-- Backdrop --}}
            <div wire:click="closeModal" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            {{-- Modal --}}
            <div class="relative w-full max-w-lg bg-gray-900 border border-gray-700 rounded-2xl shadow-2xl z-10">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <h3 class="text-sm font-black text-white">
                        {{ $editing_service_id ? 'Editar Servicio' : 'Nuevo Servicio' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Form --}}
                <form wire:submit.prevent="saveService" class="p-6 space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nombre del servicio</label>
                        <input type="text" wire:model="service_name" placeholder="Ej: Cambio de pantalla LCD" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-gray-500 transition" autofocus>
                        @error('service_name') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Categoría</label>
                            <select wire:model="service_category" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gray-500 transition cursor-pointer">
                                <option value="general">⚙️ General</option>
                                <option value="smartphone">📱 Smartphones</option>
                                <option value="notebook">💻 Notebooks</option>
                                <option value="console">🎮 Consolas</option>
                                <option value="tablet">📟 Tablets</option>
                                <option value="smartwatch">⌚ Smartwatches</option>
                                <option value="allinone">🖥️ All-in-One</option>
                                <option value="microsoldering">🔬 Micro-soldadura</option>
                                <option value="software">💻 Software</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Precio base (CLP)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">$</span>
                                <input type="number" step="500" wire:model="service_default_price" placeholder="25000" class="w-full bg-gray-800 border border-gray-700 rounded-xl pl-8 pr-4 py-3 text-sm text-white font-bold focus:outline-none focus:border-gray-500 transition">
                            </div>
                            @error('service_default_price') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Descripción <span class="text-gray-600 font-normal">(opcional)</span></label>
                        <textarea wire:model="service_description" rows="2" placeholder="Detalle de lo que incluye este servicio..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-gray-500 transition resize-none"></textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="flex-1 bg-white text-gray-900 font-bold text-xs py-3 rounded-xl hover:bg-gray-100 transition cursor-pointer">
                            {{ $editing_service_id ? 'Guardar Cambios' : 'Crear Servicio' }}
                        </button>
                        <button type="button" wire:click="closeModal" class="px-5 py-3 text-xs font-bold text-gray-400 hover:text-white rounded-xl border border-gray-700 hover:border-gray-600 transition cursor-pointer">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
