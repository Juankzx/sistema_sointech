<div class="space-y-6 pb-20">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Gestión de Usuarios</h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Administra las cuentas de técnicos, recepcionistas y accesos del portal de clientes.</p>
        </div>
        
        <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer self-start sm:self-center">
            <x-ui.icon name="user-plus" class="w-4 h-4" />
            <span>Nuevo Usuario</span>
        </button>
    </div>

    <!-- Filter Bar -->
    <x-ui.card class="p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
            <div class="relative w-full sm:w-96">
                <x-ui.icon name="search" class="w-4 h-4 text-zinc-400 absolute left-3 top-2.5" />
                <input wire:model.live="search" type="text" placeholder="Buscar por nombre, correo o rol..." 
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>

            <span class="text-xs text-zinc-500 dark:text-zinc-400 font-medium px-1">
                {{ count($users) }} usuarios registrados
            </span>
        </div>
    </x-ui.card>

    <!-- Table -->
    <x-ui.card class="overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/75 dark:bg-zinc-850/50 text-zinc-400 font-semibold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                        <th class="px-5 py-3.5">Usuario</th>
                        <th class="px-5 py-3.5">Rol</th>
                        <th class="px-5 py-3.5">Cliente Asociado</th>
                        <th class="px-5 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/60 dark:divide-zinc-800/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-850/40 transition">
                            <!-- Name & Email -->
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/80 flex items-center justify-center font-bold text-xs text-zinc-700 dark:text-zinc-300">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</span>
                                        <span class="text-[11px] text-zinc-500 dark:text-zinc-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <!-- Role -->
                            <td class="px-5 py-3.5">
                                @php
                                    $roleColors = [
                                        'admin' => 'brand',
                                        'tecnico' => 'blue',
                                        'recepcionista' => 'emerald',
                                        'cliente' => 'amber',
                                    ];
                                    $badgeVariant = $roleColors[$user->role] ?? 'zinc';
                                @endphp
                                <x-ui.badge :variant="$badgeVariant">
                                    {{ ucfirst($user->role) }}
                                </x-ui.badge>
                            </td>
                            <!-- Associated Client -->
                            <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-400">
                                @if($user->role === 'cliente' && $user->client)
                                    <span class="font-medium text-zinc-900 dark:text-zinc-200">{{ $user->client->full_name }}</span>
                                @else
                                    <span class="text-zinc-400 italic">No aplica</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" wire:click="openResetPasswordModal({{ $user->id }})" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-[11px] font-medium transition cursor-pointer" title="Restablecer Contraseña Directamente">
                                        <x-ui.icon name="key" class="w-3.5 h-3.5 text-zinc-400" />
                                        <span class="hidden lg:inline">Clave</span>
                                    </button>
                                    <button type="button" wire:click="sendPasswordResetLink({{ $user->id }})" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-[11px] font-medium transition cursor-pointer" title="Enviar enlace al correo">
                                        <x-ui.icon name="send" class="w-3.5 h-3.5 text-zinc-400" />
                                        <span class="hidden lg:inline">Enviar Enlace</span>
                                    </button>
                                    <button type="button" wire:click="editUser({{ $user->id }})" class="p-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer" title="Editar Usuario">
                                        <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-400 text-xs">
                                No se encontraron usuarios que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y divide-zinc-200/60 dark:divide-zinc-800/60">
            @forelse($users as $user)
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700/80 flex items-center justify-center font-bold text-xs text-zinc-700 dark:text-zinc-300">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <span class="font-semibold text-zinc-900 dark:text-zinc-100 text-xs block">{{ $user->name }}</span>
                                <span class="text-[11px] text-zinc-500">{{ $user->email }}</span>
                            </div>
                        </div>
                        <button type="button" wire:click="editUser({{ $user->id }})" class="p-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            <x-ui.icon name="edit" class="w-3.5 h-3.5" />
                        </button>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <div>
                            @php
                                $roleColors = [
                                    'admin' => 'brand',
                                    'tecnico' => 'blue',
                                    'recepcionista' => 'emerald',
                                    'cliente' => 'amber',
                                ];
                                $badgeVariant = $roleColors[$user->role] ?? 'zinc';
                            @endphp
                            <x-ui.badge :variant="$badgeVariant">
                                {{ ucfirst($user->role) }}
                            </x-ui.badge>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" wire:click="openResetPasswordModal({{ $user->id }})" class="px-2 py-1 rounded-lg border border-zinc-200 dark:border-zinc-700 text-[11px] text-zinc-700 dark:text-zinc-300">
                                Clave
                            </button>
                            <button type="button" wire:click="sendPasswordResetLink({{ $user->id }})" class="px-2 py-1 rounded-lg border border-zinc-200 dark:border-zinc-700 text-[11px] text-zinc-700 dark:text-zinc-300">
                                Enlace
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-zinc-400 text-xs">
                    No se encontraron usuarios.
                </div>
            @endforelse
        </div>
    </x-ui.card>

    <!-- Modal: Add/Edit User -->
    @if($showModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-zinc-950/70 backdrop-blur-xs transition-opacity"></div>
            <div class="relative z-10 w-full max-w-lg max-h-[90dvh] overflow-y-auto overscroll-contain rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xl my-auto">
                    <div class="flex items-center justify-between p-5 border-b border-zinc-200 dark:border-zinc-800">
                        <div class="flex items-center gap-2">
                            <x-ui.icon name="user" class="w-4 h-4 text-zinc-500" />
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" id="modal-title">
                                {{ $editingUserId ? 'Editar Usuario' : 'Nuevo Usuario' }}
                            </h3>
                        </div>
                        <button type="button" wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                            <x-ui.icon name="x" class="w-4 h-4" />
                        </button>
                    </div>

                    <form wire:submit.prevent="saveUser" class="p-5 sm:p-6 space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nombre Completo *</label>
                            <input wire:model="name" type="text" placeholder="Ej: Juan Pérez" 
                                class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Correo Electrónico *</label>
                            <input wire:model="email" type="email" placeholder="usuario@sointech.cl" 
                                class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                                Contraseña {{ $editingUserId ? '(Dejar en blanco para conservar)' : '*' }}
                            </label>
                            <input wire:model="password" type="password" placeholder="Mínimo 6 caracteres" 
                                class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Rol de Sistema *</label>
                            <select wire:model.live="role" class="w-full px-3 py-2 text-xs rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                <option value="admin">Administrador (Control Total)</option>
                                <option value="tecnico">Técnico (Taller y Reparaciones)</option>
                                <option value="recepcionista">Recepcionista (Ingresos y Caja)</option>
                                <option value="cliente">Cliente (Portal de Seguimiento)</option>
                            </select>
                            @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Client link -->
                        @if($role === 'cliente')
                        <div class="p-3.5 rounded-xl border border-blue-200 dark:border-blue-800/60 bg-blue-50/50 dark:bg-blue-950/20 space-y-1.5">
                            <label class="block text-xs font-medium text-blue-900 dark:text-blue-300">Vincular a Cliente Existente *</label>
                            <select wire:model="client_id" class="w-full px-3 py-2 text-xs rounded-lg border border-blue-300 dark:border-blue-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                <option value="">-- Seleccionar Cliente --</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}">{{ $c->full_name }} ({{ $c->rut_dni ?? 'Sin RUT' }})</option>
                                @endforeach
                            </select>
                            @error('client_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                Cancelar
                            </button>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                                <span wire:loading.remove wire:target="saveUser">Guardar Usuario</span>
                                <span wire:loading wire:target="saveUser">Guardando...</span>
                            </button>
                        </div>
                    </form>
                </div>
        </div>
    @endif

    <!-- Reset Password Modal -->
    @if($showResetModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto overscroll-contain flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-zinc-950/70 backdrop-blur-xs transition-opacity"></div>
            <div class="relative z-10 w-full max-w-md max-h-[90dvh] overflow-y-auto overscroll-contain rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xl my-auto">
                    <div class="flex items-center justify-between p-5 border-b border-zinc-200 dark:border-zinc-800">
                        <div class="flex items-center gap-2 text-zinc-900 dark:text-zinc-100">
                            <x-ui.icon name="key" class="w-4 h-4 text-zinc-500" />
                            <h3 class="text-sm font-semibold">Restablecer Contraseña</h3>
                        </div>
                        <button type="button" wire:click="$set('showResetModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                            <x-ui.icon name="x" class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4">
                        <div class="p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-850/50 text-xs">
                            <span class="text-zinc-500 block">Usuario a modificar:</span>
                            <span class="font-semibold text-zinc-900 dark:text-zinc-100 block">{{ $resetUserName }}</span>
                            <span class="text-zinc-400 font-mono text-[11px]">{{ $resetUserEmail }}</span>
                        </div>

                        <form wire:submit.prevent="saveNewPassword" class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Nueva Contraseña *</label>
                                <div class="flex items-center gap-2">
                                    <input wire:model="newPassword" type="text" placeholder="Ingresa o genera nueva clave" 
                                        class="flex-1 px-3 py-2 text-xs font-mono rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                                    <button type="button" wire:click="generateRandomPassword" class="px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-xs font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap transition cursor-pointer">
                                        Generar
                                    </button>
                                </div>
                                @error('newPassword') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <button type="button" wire:click="$set('showResetModal', false)" class="px-4 py-2 rounded-xl text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 transition cursor-pointer">
                                    Cancelar
                                </button>
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer">
                                    <x-ui.icon name="check" class="w-4 h-4" />
                                    Guardar Nueva Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    @endif
</div>
