<div class="space-y-6 animate-fade-in">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Gestión de Usuarios</h1>
            <p class="text-sm text-gray-400 mt-1">Administra los accesos al sistema y credenciales de clientes.</p>
        </div>
        
        <button wire:click="openCreateModal" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded-2xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transition duration-200 cursor-pointer self-start sm:self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Agregar Usuario
        </button>
    </div>

    <!-- FILTER BAR (SEARCH) -->
    <div class="bg-gray-850 p-5 rounded-3xl border border-gray-800 shadow-md flex flex-col sm:flex-row gap-4 items-center justify-between">
        <!-- Search Input -->
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Buscar por nombre, correo, rol..." 
                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition">
        </div>

        <span class="text-xs font-semibold text-gray-400">
            {{ count($users) }} usuarios registrados
        </span>
    </div>

    <!-- TABLE -->
    <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
        <!-- DESKTOP TABLE -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-900/40 text-gray-400 font-semibold uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4">Rol</th>
                        <th class="px-6 py-4">Cliente Asociado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-900/20 transition">
                            <!-- Name & Email -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center font-bold text-xs text-blue-400">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-white">{{ $user->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <!-- Role -->
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-900/30 text-purple-400 border-purple-700/50',
                                        'tecnico' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                        'recepcionista' => 'bg-emerald-900/30 text-emerald-400 border-emerald-700/50',
                                        'cliente' => 'bg-orange-900/30 text-orange-400 border-orange-700/50',
                                    ];
                                    $colorClass = $roleColors[$user->role] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $colorClass }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <!-- Associated Client -->
                            <td class="px-6 py-4 text-gray-300 text-xs">
                                @if($user->role === 'cliente' && $user->client)
                                    {{ $user->client->full_name }}
                                @else
                                    <span class="text-gray-500 italic">N/A</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="openResetPasswordModal({{ $user->id }})" class="p-2 bg-amber-950/40 hover:bg-amber-900/60 border border-amber-800/50 rounded-xl text-amber-400 hover:text-amber-300 transition duration-150 inline-flex items-center gap-1 text-xs font-semibold" title="Restablecer Contraseña Directamente">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        <span class="hidden lg:inline">Clave</span>
                                    </button>
                                    <button wire:click="sendPasswordResetLink({{ $user->id }})" class="p-2 bg-blue-950/40 hover:bg-blue-900/60 border border-blue-800/50 rounded-xl text-blue-400 hover:text-blue-300 transition duration-150 inline-flex items-center gap-1 text-xs font-semibold" title="Enviar enlace de restablecimiento al correo">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="hidden lg:inline">Enviar Enlace</span>
                                    </button>
                                    <button wire:click="editUser({{ $user->id }})" class="p-2 bg-gray-800 hover:bg-gray-700 rounded-xl text-gray-300 hover:text-white transition duration-150 inline-flex items-center justify-center" title="Editar Usuario">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                No se encontraron usuarios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="md:hidden flex flex-col gap-3 p-4">
            @forelse($users as $user)
                <div class="bg-gray-800/50 border border-gray-700/60 rounded-2xl p-4 flex flex-col gap-3">
                    <div class="flex items-center justify-between border-b border-gray-700/50 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center font-bold text-sm text-blue-400">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-sm">{{ $user->name }}</span>
                                <span class="text-[10px] text-gray-400">{{ $user->email }}</span>
                            </div>
                        </div>
                        <button wire:click="editUser({{ $user->id }})" class="p-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-blue-400 hover:text-blue-300 transition duration-150 inline-flex items-center justify-center" title="Editar Usuario">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Rol</span>
                            @php
                                $roleColors = [
                                    'admin' => 'bg-purple-900/30 text-purple-400 border-purple-700/50',
                                    'tecnico' => 'bg-blue-900/30 text-blue-400 border-blue-700/50',
                                    'recepcionista' => 'bg-emerald-900/30 text-emerald-400 border-emerald-700/50',
                                    'cliente' => 'bg-orange-900/30 text-orange-400 border-orange-700/50',
                                ];
                                $colorClass = $roleColors[$user->role] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                            @endphp
                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border {{ $colorClass }}">
                                {{ $user->role }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase">Cliente Asociado</span>
                            <span class="text-white mt-1 block">
                                @if($user->role === 'cliente' && $user->client)
                                    {{ $user->client->full_name }}
                                @else
                                    <span class="text-gray-500 italic text-xs">N/A</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500 text-sm">No se encontraron usuarios.</div>
            @endforelse
        </div>
    </div>

    <!-- MODAL: ADD/EDIT USER -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-gray-850 border border-gray-700 px-6 py-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate-scale-up">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-6">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2" id="modal-title">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            {{ $editingUserId ? 'Editar Usuario' : 'Nuevo Usuario' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-1 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveUser" class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Nombre *</label>
                            <input wire:model="name" type="text" placeholder="Nombre completo o Alias" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                            @error('name') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Correo Electrónico *</label>
                            <input wire:model="email" type="email" placeholder="usuario@ejemplo.com" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                            @error('email') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">
                                Contraseña {{ $editingUserId ? '(Dejar en blanco para mantener)' : '*' }}
                            </label>
                            <input wire:model="password" type="password" placeholder="Mínimo 6 caracteres" 
                                class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                            @error('password') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Rol del Usuario *</label>
                            <select wire:model.live="role" class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                                <option value="admin">Administrador</option>
                                <option value="tecnico">Técnico</option>
                                <option value="recepcionista">Recepcionista</option>
                                <option value="cliente">Cliente (Acceso Restringido)</option>
                            </select>
                            @error('role') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Client Dropdown (only if role is cliente) -->
                        @if($role === 'cliente')
                        <div class="animate-fade-in">
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 text-blue-400">Vincular a Cliente Existente *</label>
                            <select wire:model="client_id" class="w-full bg-gray-900 border border-blue-900/50 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                                <option value="">-- Seleccionar Cliente --</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}">{{ $c->full_name }} ({{ $c->rut_dni ?? 'Sin RUT' }})</option>
                                @endforeach
                            </select>
                            @error('client_id') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/30 transition flex items-center gap-2 cursor-pointer">
                                <span wire:loading.remove wire:target="saveUser">Guardar</span>
                                <span wire:loading wire:target="saveUser" class="flex items-center gap-1.5">
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- RESET PASSWORD MODAL -->
    @if($showResetModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-950/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-gray-850 rounded-3xl border border-gray-800 shadow-2xl max-w-md w-full overflow-hidden animate-fade-in">
                <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-gray-900/50">
                    <div class="flex items-center gap-2 text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        <h3 class="text-base font-bold text-white">Restablecer Contraseña</h3>
                    </div>
                    <button wire:click="$set('showResetModal', false)" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="bg-gray-900/60 p-3.5 rounded-2xl border border-gray-700/60 text-xs">
                        <span class="text-gray-400 block mb-0.5">Usuario a modificar:</span>
                        <strong class="text-white font-bold block text-sm">{{ $resetUserName }}</strong>
                        <span class="text-blue-400 font-mono">{{ $resetUserEmail }}</span>
                    </div>

                    <form wire:submit.prevent="saveNewPassword" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Nueva Contraseña *</label>
                            <div class="flex items-center gap-2">
                                <input wire:model="newPassword" type="text" placeholder="Ingresa o genera nueva clave" 
                                    class="w-full bg-gray-900 border border-gray-700 rounded-xl py-2.5 px-4 text-sm text-white font-mono placeholder-gray-500 focus:outline-none focus:border-amber-500 transition">
                                <button type="button" wire:click="generateRandomPassword" class="px-3 py-2.5 bg-gray-800 hover:bg-gray-700 text-amber-400 border border-amber-800/40 rounded-xl text-xs font-bold whitespace-nowrap transition" title="Generar clave aleatoria">
                                    🎲 Generar
                                </button>
                            </div>
                            @error('newPassword') <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800">
                            <button type="button" wire:click="$set('showResetModal', false)" class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded-xl transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-amber-500/20 transition flex items-center gap-2 cursor-pointer">
                                🔑 Guardar Nueva Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
