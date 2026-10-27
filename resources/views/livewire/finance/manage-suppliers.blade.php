<div class="space-y-6 pb-16 md:pb-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900/50">
                    <x-ui.icon name="truck" class="w-5 h-5" />
                </span>
                Proveedores
            </h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">Gestiona tu directorio de proveedores y mayoristas.</p>
        </div>
        
        <div class="flex items-center gap-3 self-start sm:self-auto">
            @if(!$showForm)
                <button wire:click="createSupplier" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded-lg shadow-xs transition duration-150 cursor-pointer">
                    <x-ui.icon name="plus" class="w-4 h-4" />
                    Nuevo Proveedor
                </button>
            @endif
        </div>
    </div>

    @if(session()->has('error'))
        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="alert-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" />
            <span class="text-red-800 dark:text-red-300 text-xs font-medium">{{ session('error') }}</span>
        </div>
    @endif
    
    @if(session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-lg p-3.5 flex items-center gap-3">
            <x-ui.icon name="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="text-emerald-800 dark:text-emerald-300 text-xs font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if($showForm)
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-xs max-w-4xl mx-auto">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight mb-4 flex items-center gap-2">
                <x-ui.icon name="truck" class="w-4 h-4 text-orange-500" />
                {{ $supplierId ? 'Editar Proveedor' : 'Nuevo Proveedor' }}
            </h3>
            
            <form wire:submit.prevent="saveSupplier" class="space-y-3.5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Razón Social o Nombre *</label>
                        <input type="text" wire:model="name" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: Importadora Tecno SPA">
                        @error('name') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">RUT (Opcional)</label>
                        <input type="text" wire:model="rut" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: 76.123.456-7">
                        @error('rut') <span class="text-xs text-red-600 dark:text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Teléfono (Opcional)</label>
                        <input type="text" wire:model="phone" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: +56 9 1234 5678">
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Email (Opcional)</label>
                        <input type="email" wire:model="email" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: ventas@proveedor.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Contacto / Vendedor (Opcional)</label>
                        <input type="text" wire:model="contact_name" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: Juan Pérez">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Dirección (Opcional)</label>
                        <input type="text" wire:model="address" class="w-full bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700/80 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block p-2 transition" placeholder="Ej: Av. Providencia 1234">
                    </div>
                </div>

                <div class="flex justify-end gap-2.5 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                    <button type="button" wire:click="cancel" class="px-4 py-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-lg transition cursor-pointer">Cancelar</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition shadow-xs cursor-pointer">Guardar Proveedor</button>
                </div>
            </form>
        </div>
    @else
        <!-- Buscador -->
        <div class="max-w-md">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-400">
                    <x-ui.icon name="search" class="w-4 h-4" />
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-xs rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 block pl-9 p-2 shadow-xs transition" placeholder="Buscar proveedor por nombre o RUT...">
            </div>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50/80 dark:bg-zinc-850/60 border-b border-zinc-200 dark:border-zinc-800 text-[10px] uppercase text-zinc-500 dark:text-zinc-400 font-semibold tracking-wider">
                            <th class="px-4 py-3">Razón Social / RUT</th>
                            <th class="px-4 py-3">Contacto</th>
                            <th class="px-4 py-3">Teléfono / Email</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-zinc-800 dark:text-zinc-200 text-xs">{{ $supplier->name }}</div>
                                    @if($supplier->rut)
                                        <div class="text-[10px] font-mono text-zinc-400">{{ $supplier->rut }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">
                                    {{ $supplier->contact_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($supplier->phone)
                                        <div class="flex items-center gap-1.5 text-zinc-600 dark:text-zinc-300">
                                            <x-ui.icon name="phone" class="w-3 h-3 text-zinc-400" />
                                            <span class="text-xs font-mono">{{ $supplier->phone }}</span>
                                        </div>
                                    @endif
                                    @if($supplier->email)
                                        <div class="flex items-center gap-1.5 text-zinc-500 dark:text-zinc-400 mt-0.5">
                                            <x-ui.icon name="mail" class="w-3 h-3 text-zinc-400" />
                                            <span class="text-xs">{{ $supplier->email }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="editSupplier({{ $supplier->id }})" class="p-1.5 text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded transition cursor-pointer" title="Editar">
                                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                        </button>
                                        <button wire:click="deleteSupplier({{ $supplier->id }})" wire:confirm="¿Estás seguro de eliminar este proveedor?" class="p-1.5 text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 rounded transition cursor-pointer" title="Eliminar">
                                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500 text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <x-ui.icon name="truck" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                                        <span>No se encontraron proveedores.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($suppliers->hasPages())
                <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-3">
            @forelse($suppliers as $supplier)
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 shadow-xs flex flex-col gap-2.5">
                    <div class="border-b border-zinc-100 dark:border-zinc-800 pb-2">
                        <div class="font-bold text-zinc-900 dark:text-zinc-100 text-sm">{{ $supplier->name }}</div>
                        @if($supplier->rut)
                            <div class="text-[10px] font-mono text-zinc-400 mt-0.5">RUT: {{ $supplier->rut }}</div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 gap-1.5 text-xs">
                        @if($supplier->contact_name)
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Contacto</span>
                            <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $supplier->contact_name }}</span>
                        </div>
                        @endif
                        
                        @if($supplier->phone)
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Teléfono</span>
                            <span class="text-zinc-700 dark:text-zinc-300 font-mono">{{ $supplier->phone }}</span>
                        </div>
                        @endif
                        
                        @if($supplier->email)
                        <div>
                            <span class="block text-[10px] text-zinc-400 uppercase tracking-wider">Email</span>
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $supplier->email }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                        <button wire:click="editSupplier({{ $supplier->id }})" class="flex-1 py-1.5 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-xs font-semibold rounded-lg transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                            Editar
                        </button>
                        <button wire:click="deleteSupplier({{ $supplier->id }})" wire:confirm="¿Estás seguro de eliminar este proveedor?" class="flex-1 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 text-xs font-semibold rounded-lg transition flex items-center justify-center gap-1.5 border border-red-200 dark:border-red-800/60 cursor-pointer">
                            <x-ui.icon name="trash" class="w-3.5 h-3.5" />
                            Eliminar
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-8 text-center text-zinc-400 dark:text-zinc-500">
                    <x-ui.icon name="truck" class="w-8 h-8 mx-auto mb-2 text-zinc-300 dark:text-zinc-600" />
                    <p class="font-medium text-xs">No se encontraron proveedores.</p>
                </div>
            @endforelse
            
            @if($suppliers->hasPages())
                <div class="pt-2">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    @endif
</div>