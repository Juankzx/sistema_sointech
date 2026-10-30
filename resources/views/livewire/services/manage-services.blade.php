<div class="space-y-6 pb-16 md:pb-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="wrench" class="w-5 h-5" />
                </span>
                Catálogo de Servicios
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Precios base sugeridos para mano de obra técnica y servicios de taller.</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer self-start sm:self-auto">
            <x-ui.icon name="plus" class="w-4 h-4" />
            Nuevo Servicio
        </button>
    </div>

    {{-- FLASH --}}
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 px-3.5 py-2.5 rounded-lg text-xs font-medium flex items-center gap-2" x-data x-init="setTimeout(() => $el.remove(), 3000)">
            <x-ui.icon name="check-circle" class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" />
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- FILTERS BAR --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl p-3.5 border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col sm:flex-row items-start sm:items-center gap-3">
        {{-- Search --}}
        <div class="relative w-full sm:w-72">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                <x-ui.icon name="search" class="w-4 h-4" />
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar servicio..." class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg pl-9 pr-3 py-1.5 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition">
        </div>

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-1.5">
            <button wire:click="setCategory('')" class="px-2.5 py-1 rounded-md text-xs font-medium transition cursor-pointer {{ $filterCategory === '' ? 'bg-orange-600 text-white shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                Todos <span class="ml-1 opacity-70">{{ $totalServices }}</span>
            </button>
            @foreach($categoryCounts as $cat => $count)
                @php
                    $catLabels = [
                        'general' => 'General',
                        'smartphone' => 'Smartphones',
                        'notebook' => 'Notebooks',
                        'console' => 'Consolas',
                        'tablet' => 'Tablets',
                        'smartwatch' => 'Smartwatches',
                        'allinone' => 'All-in-One',
                        'microsoldering' => 'Micro-soldadura',
                        'software' => 'Software',
                    ];
                @endphp
                <button wire:click="setCategory('{{ $cat }}')" class="px-2.5 py-1 rounded-md text-xs font-medium transition cursor-pointer {{ $filterCategory === $cat ? 'bg-orange-600 text-white shadow-xs' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                    {{ $catLabels[$cat] ?? ucfirst($cat) }} <span class="ml-1 opacity-70">{{ $count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-xs">
        @if(count($services) > 0)
            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            <th class="px-4 py-3">Servicio</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3 text-right">Precio Base</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-right w-24">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @foreach($services as $srv)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition duration-150">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-zinc-800 dark:text-zinc-200 text-xs">{{ $srv->name }}</div>
                                    @if($srv->description)
                                        <div class="text-[11px] text-zinc-400 mt-0.5 truncate max-w-sm">{{ $srv->description }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <x-ui.badge variant="neutral" size="xs">
                                        {{ str_replace(['⚙️', '📱', '💻', '🎮', '📟', '⌚', '🖥️', '🔬'], '', $srv->category_label) }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <span class="font-mono font-bold text-zinc-900 dark:text-zinc-100 text-xs">${{ number_format($srv->default_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button wire:click="toggleStatus({{ $srv->id }})" class="cursor-pointer" title="Cambiar estado">
                                        @if($srv->is_active)
                                            <x-ui.badge variant="success" size="xs">Activo</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="neutral" size="xs">Inactivo</x-ui.badge>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($confirmingDeleteId === $srv->id)
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="deleteService({{ $srv->id }})" class="text-[11px] font-semibold text-red-600 hover:text-red-700 px-2 py-0.5 rounded transition cursor-pointer">Sí</button>
                                            <button wire:click="cancelDelete" class="text-[11px] text-zinc-400 hover:text-zinc-600 px-2 py-0.5 rounded transition cursor-pointer">No</button>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="openEditModal({{ $srv->id }})" class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 rounded transition cursor-pointer" title="Editar">
                                                <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                            </button>
                                            <button wire:click="confirmDelete({{ $srv->id }})" class="p-1.5 text-zinc-400 hover:text-red-500 rounded transition cursor-pointer" title="Eliminar">
                                                <x-ui.icon name="trash" class="w-3.5 h-3.5" />
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
            <div class="md:hidden divide-y divide-zinc-100 dark:divide-zinc-800">
                @foreach($services as $srv)
                    <div class="p-3.5 flex items-center justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $srv->name }}</span>
                                @if($srv->is_active)
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 shrink-0"></span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-zinc-400">
                                <span>{{ str_replace(['⚙️', '📱', '💻', '🎮', '📟', '⌚', '🖥️', '🔬'], '', $srv->category_label) }}</span>
                                <span>•</span>
                                <span class="font-bold text-zinc-900 dark:text-zinc-100 font-mono">${{ number_format($srv->default_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button wire:click="openEditModal({{ $srv->id }})" class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 rounded transition cursor-pointer">
                                <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                            </button>
                            <button wire:click="confirmDelete({{ $srv->id }})" class="p-1.5 text-zinc-400 hover:text-red-500 rounded transition cursor-pointer">
                                <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 px-4">
                <x-ui.icon name="wrench" class="w-8 h-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">No se encontraron servicios con los filtros actuales.</p>
            </div>
        @endif
    </div>

    {{-- CREATE/EDIT MODAL --}}
    @if($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4 bg-zinc-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-2xl w-full max-w-lg max-h-[90dvh] overflow-y-auto overscroll-contain p-5 relative my-auto">
                {{-- Header --}}
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800 mb-4">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                        <x-ui.icon name="wrench" class="w-4 h-4 text-orange-500" />
                        {{ $editing_service_id ? 'Editar Servicio' : 'Nuevo Servicio' }}
                    </h3>
                    <button wire:click="closeModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition cursor-pointer">
                        <x-ui.icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                {{-- Form --}}
                <form wire:submit.prevent="saveService" class="space-y-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Nombre del servicio *</label>
                        <input type="text" wire:model="service_name" placeholder="Ej: Cambio de pantalla LCD" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition" autofocus>
                        @error('service_name') <span class="text-red-600 dark:text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Categoría</label>
                            <select wire:model="service_category" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-orange-500 transition cursor-pointer">
                                <option value="general">General</option>
                                <option value="smartphone">Smartphones</option>
                                <option value="notebook">Notebooks</option>
                                <option value="console">Consolas</option>
                                <option value="tablet">Tablets</option>
                                <option value="smartwatch">Smartwatches</option>
                                <option value="allinone">All-in-One</option>
                                <option value="microsoldering">Micro-soldadura</option>
                                <option value="software">Software</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Precio base (CLP)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center text-zinc-400 font-semibold text-xs">$</span>
                                <input type="number" step="500" wire:model="service_default_price" placeholder="25000" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg pl-6 pr-3 py-2 text-xs text-zinc-900 dark:text-zinc-100 font-bold focus:outline-none focus:border-orange-500 transition">
                            </div>
                            @error('service_default_price') <span class="text-red-600 dark:text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1">Descripción <span class="text-zinc-400 font-normal">(opcional)</span></label>
                        <textarea wire:model="service_description" rows="2" placeholder="Detalle de lo que incluye este servicio..." class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 rounded-lg p-2 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-orange-500 transition resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-xs cursor-pointer">
                            {{ $editing_service_id ? 'Guardar Cambios' : 'Crear Servicio' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>