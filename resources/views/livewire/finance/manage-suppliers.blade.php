<div class="px-2">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Proveedores
            </h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Gestiona tu directorio de proveedores y mayoristas.</p>
        </div>
        
        <div class="flex items-center gap-3">
            @if(!$showForm)
                <button wire:click="createSupplier" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Proveedor
                </button>
            @endif
        </div>
    </div>

    @if(session()->has('error'))
        <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif
    
    @if(session()->has('message'))
        <div class="mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    @if($showForm)
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-lg shadow-black/20 mb-8 max-w-4xl mx-auto">
            <h3 class="text-lg font-black text-white tracking-tight mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ $supplierId ? 'Editar Proveedor' : 'Nuevo Proveedor' }}
            </h3>
            
            <form wire:submit.prevent="saveSupplier">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Razón Social o Nombre *</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: Importadora Tecno SPA">
                        @error('name') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">RUT (Opcional)</label>
                        <input type="text" wire:model="rut" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: 76.123.456-7">
                        @error('rut') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Teléfono (Opcional)</label>
                        <input type="text" wire:model="phone" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: +56 9 1234 5678">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email (Opcional)</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: ventas@proveedor.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Contacto / Vendedor (Opcional)</label>
                        <input type="text" wire:model="contact_name" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: Juan Pérez">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dirección (Opcional)</label>
                        <input type="text" wire:model="address" class="w-full bg-gray-900 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition" placeholder="Ej: Av. Providencia 1234">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-700/50">
                    <button type="button" wire:click="cancel" class="px-5 py-2.5 text-sm font-bold text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-xl transition-all">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-orange-600 hover:bg-orange-500 rounded-xl transition-all shadow-lg shadow-orange-500/20">Guardar Proveedor</button>
                </div>
            </form>
        </div>
    @else
        <!-- Buscador -->
        <div class="mb-6 relative max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block pl-10 p-3 shadow-lg shadow-black/10 transition-all" placeholder="Buscar proveedor por nombre o RUT...">
        </div>

        <!-- DESKTOP TABLE -->
        <div class="hidden md:block bg-gray-800 border border-gray-700 rounded-2xl overflow-hidden shadow-lg shadow-black/20">
            <div class="overflow-x-auto theme-scrollbar">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-900/50 border-b border-gray-700 text-[10px] uppercase text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-black">Razón Social / RUT</th>
                            <th class="px-6 py-4 font-black">Contacto</th>
                            <th class="px-6 py-4 font-black">Teléfono / Email</th>
                            <th class="px-6 py-4 font-black text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white">{{ $supplier->name }}</div>
                                    @if($supplier->rut)
                                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $supplier->rut }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-400">
                                    {{ $supplier->contact_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($supplier->phone)
                                        <div class="flex items-center gap-1.5 text-gray-300 mb-1">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            <span class="text-xs">{{ $supplier->phone }}</span>
                                        </div>
                                    @endif
                                    @if($supplier->email)
                                        <div class="flex items-center gap-1.5 text-gray-300">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs">{{ $supplier->email }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="editSupplier({{ $supplier->id }})" class="p-2 text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition-all" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="deleteSupplier({{ $supplier->id }})" wire:confirm="¿Estás seguro de eliminar este proveedor?" class="p-2 text-gray-400 hover:text-red-400 bg-gray-800 hover:bg-red-500/10 rounded-lg transition-all" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <p class="font-semibold text-gray-400">No se encontraron proveedores.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($suppliers->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50 bg-gray-900/30">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-4 mt-4">
            @forelse($suppliers as $supplier)
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4 shadow-lg flex flex-col gap-3">
                    <div class="border-b border-gray-700/50 pb-3">
                        <div class="font-bold text-white text-base">{{ $supplier->name }}</div>
                        @if($supplier->rut)
                            <div class="text-[10px] text-gray-400 mt-1">RUT: {{ $supplier->rut }}</div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 gap-2 text-xs">
                        @if($supplier->contact_name)
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Contacto</span>
                            <span class="text-gray-300 font-medium">{{ $supplier->contact_name }}</span>
                        </div>
                        @endif
                        
                        @if($supplier->phone)
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Teléfono</span>
                            <span class="text-gray-300">{{ $supplier->phone }}</span>
                        </div>
                        @endif
                        
                        @if($supplier->email)
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Email</span>
                            <span class="text-gray-300">{{ $supplier->email }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-gray-700/50 mt-1">
                        <button wire:click="editSupplier({{ $supplier->id }})" class="flex-1 py-2 bg-gray-700 hover:bg-gray-600 text-gray-300 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Editar
                        </button>
                        <button wire:click="deleteSupplier({{ $supplier->id }})" wire:confirm="¿Estás seguro de eliminar este proveedor?" class="flex-1 py-2 bg-red-900/30 hover:bg-red-800/40 text-red-400 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2 border border-red-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Eliminar
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <p class="font-semibold text-gray-400 text-sm">No se encontraron proveedores.</p>
                </div>
            @endforelse
            
            @if($suppliers->hasPages())
                <div class="pt-4">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
