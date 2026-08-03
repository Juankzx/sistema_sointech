<div class="space-y-6 animate-fade-in pb-16">

    {{-- CSS Custom Scrollbar para evitar la barra blanca fea del navegador --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0d1117;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }
    </style>

    {{-- Flash Notifications --}}
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl text-sm font-bold flex items-center justify-between gap-3 animate-fade-in"
            style="background:rgba(16,185,129,.1); border:1.5px solid rgba(16,185,129,.25); color:#34d399;">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 rounded-2xl text-sm font-bold flex items-center justify-between gap-3 animate-fade-in"
            style="background:rgba(239,68,68,.1); border:1.5px solid rgba(239,68,68,.25); color:#fca5a5;">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- ══ HEADER PREMIUM ══ --}}
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-7 border"
        style="background:linear-gradient(135deg, #0a1628 0%, #0d2137 40%, #083d35 100%); border-color:rgba(255,255,255,.06);">
        <div class="absolute inset-0 opacity-5"
            style="background-image: radial-gradient(circle at 1px 1px, rgba(0,198,182,0.6) 1px, transparent 0); background-size: 24px 24px;">
        </div>
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(0,198,182,0.12) 0%, transparent 70%);"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border mb-2.5"
                    style="background:rgba(0,198,182,.1); color:#00C6B6; border-color:rgba(0,198,182,.25);">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    Sointech • CRM
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Gestión de Clientes</h1>
                <p class="text-xs sm:text-sm mt-1" style="color:rgba(180,210,205,0.7);">
                    Administra la base de datos de clientes, consulta su historial de reparaciones y envía notificaciones.
                </p>
            </div>

            <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider px-5 py-3.5 rounded-2xl shadow-xl transition-all duration-200 cursor-pointer self-start sm:self-center shrink-0"
                style="background:linear-gradient(135deg,#00C6B6 0%,#2563eb 100%); color:#ffffff; box-shadow:0 8px 20px rgba(0,198,182,.25);"
                onmouseover="this.style.transform='translateY(-1px)';"
                onmouseout="this.style.transform='none';">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nuevo Cliente
            </button>
        </div>
    </div>

    {{-- ══ TARJETAS DE MÉTRICAS RÁPIDAS ══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total Clientes --}}
        <div class="rounded-2xl p-4 flex items-center gap-4" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Total Clientes</div>
                <div class="text-xl font-black text-white mt-0.5">{{ count($clients) }}</div>
            </div>
        </div>

        {{-- Con WhatsApp --}}
        <div class="rounded-2xl p-4 flex items-center gap-4" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#4ade80;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3h3m-3 3h3"/>
                </svg>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Contactos Directos</div>
                <div class="text-xl font-black text-white mt-0.5">{{ $clients->whereNotNull('phone')->count() }}</div>
            </div>
        </div>

        {{-- Con Órdenes --}}
        <div class="rounded-2xl p-4 flex items-center gap-4" style="background:#0d1117; border:1.5px solid #1f2937;">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#60a5fa;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Clientes Activos</div>
                <div class="text-xl font-black text-white mt-0.5">{{ $clients->where('work_orders_count', '>', 0)->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ══ BARRA DE BÚSQUEDA ══ --}}
    <div class="rounded-2xl p-4 flex flex-col sm:flex-row gap-3 items-center justify-between"
        style="background:#0d1117; border:1.5px solid #1f2937;">
        <div class="relative w-full sm:w-96">
            <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none" style="color:#4b5563;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input wire:model.live.debounce.150ms="search" type="text"
                placeholder="Buscar por nombre, RUT, teléfono o email..."
                class="w-full rounded-xl py-2.5 pl-10 pr-9 text-xs font-medium text-white placeholder-gray-600 transition-all duration-200 focus:outline-none"
                style="background:#111827; border:1.5px solid #1f2937;"
                onfocus="this.style.borderColor='#00C6B6'; this.style.boxShadow='0 0 0 3px rgba(0,198,182,.12)';"
                onblur="this.style.borderColor='#1f2937'; this.style.boxShadow='none';">

            @if($search)
                <button type="button" wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
        </div>

        <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider self-end sm:self-center shrink-0">
            Mostrando <span class="text-teal-400 font-mono">{{ count($clients) }}</span> cliente{{ count($clients) !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- ══ TABLA DESKTOP ══ --}}
    <div class="hidden md:block rounded-2xl overflow-hidden shadow-2xl"
        style="background:#0d1117; border:1.5px solid #1f2937;">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-gray-500 font-extrabold uppercase text-[10px] tracking-widest border-b"
                        style="background:#111827; border-color:#1f2937;">
                        <th class="px-5 py-4">Cliente</th>
                        <th class="px-5 py-4">RUT / DNI</th>
                        <th class="px-5 py-4">Teléfono</th>
                        <th class="px-5 py-4">Correo Electrónico</th>
                        <th class="px-5 py-4 text-center">Órdenes</th>
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($clients as $client)
                        <tr class="transition-colors duration-150 group"
                            onmouseover="this.style.background='#111827';"
                            onmouseout="this.style.background='transparent';">
                            {{-- Nombre --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                        style="{{ $client->company_name ? 'background:rgba(249,115,22,.1); border:1px solid rgba(249,115,22,.25);' : 'background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.18);' }}">
                                        @if($client->company_name)
                                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        @else
                                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        @if($client->company_name)
                                            <div class="font-bold text-orange-400 text-sm leading-tight flex items-center gap-1.5">
                                                <span>{{ $client->company_name }}</span>
                                                <span class="px-1.5 py-0.5 bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[9px] font-black rounded uppercase">Empresa B2B</span>
                                            </div>
                                            <div class="text-[11px] text-gray-300 font-medium mt-0.5">Contacto: {{ $client->full_name }}</div>
                                        @else
                                            <div class="font-bold text-white text-sm leading-tight">{{ $client->full_name }}</div>
                                            <div class="text-[10px] text-gray-500 mt-0.5">Persona Natural</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- RUT / DNI --}}
                            <td class="px-5 py-4 font-mono text-xs">
                                @if($client->rut_dni)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-gray-300 font-bold"
                                        style="background:#111827; border:1px solid #1f2937;">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                        </svg>
                                        {{ $client->rut_dni }}
                                    </span>
                                @else
                                    <span class="text-gray-600 text-xs italic">Sin RUT</span>
                                @endif
                            </td>

                            {{-- Teléfono / WhatsApp --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-white text-xs">{{ $client->phone }}</span>
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $client->phone);
                                    @endphp
                                    @if($cleanPhone)
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                                            title="Abrir Chat WhatsApp"
                                            class="w-7 h-7 rounded-lg flex items-center justify-center transition cursor-pointer"
                                            style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.2); color:#4ade80;"
                                            onmouseover="this.style.background='rgba(34,197,94,.2)';"
                                            onmouseout="this.style.background='rgba(34,197,94,.1)';">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a.596.596 0 01-.787-.787l.458-1.52A8.196 8.196 0 013 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-5 py-4 text-xs text-gray-300">
                                @if($client->email)
                                    <span class="flex items-center gap-1.5 truncate max-w-[200px]" title="{{ $client->email }}">
                                        <svg class="w-3.5 h-3.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                        <span class="truncate">{{ $client->email }}</span>
                                    </span>
                                @else
                                    <span class="text-gray-600 italic">No registrado</span>
                                @endif
                            </td>

                            {{-- Órdenes --}}
                            <td class="px-5 py-4 text-center">
                                @if($client->work_orders_count > 0)
                                    <button type="button" wire:click="viewOrders({{ $client->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold transition cursor-pointer"
                                        style="background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.25); color:#60a5fa;"
                                        onmouseover="this.style.background='rgba(59,130,246,.2)';"
                                        onmouseout="this.style.background='rgba(59,130,246,.1)';">
                                        <span>📋</span>
                                        <span>{{ $client->work_orders_count }} OT{{ $client->work_orders_count > 1 ? 's' : '' }}</span>
                                    </button>
                                @else
                                    <span class="text-gray-600 text-xs">Sin OTs</span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Editar --}}
                                    <button type="button" wire:click="editClient({{ $client->id }})"
                                        title="Editar perfil"
                                        class="w-8 h-8 rounded-xl flex items-center justify-center transition cursor-pointer"
                                        style="background:#1f2937; border:1px solid #374151; color:#9ca3af;"
                                        onmouseover="this.style.background='#374151'; this.style.color='#ffffff';"
                                        onmouseout="this.style.background='#1f2937'; this.style.color='#9ca3af';">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                        </svg>
                                    </button>

                                    {{-- Eliminar --}}
                                    <button type="button" wire:click="deleteClient({{ $client->id }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar este cliente?"
                                        title="Eliminar cliente"
                                        class="w-8 h-8 rounded-xl flex items-center justify-center transition cursor-pointer"
                                        style="background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); color:#f87171;"
                                        onmouseover="this.style.background='rgba(239,68,68,.2)';"
                                        onmouseout="this.style.background='rgba(239,68,68,.08)';">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                                <div class="font-bold text-gray-400">No se encontraron clientes</div>
                                <div class="text-xs text-gray-600 mt-1">Intenta ajustando el término de búsqueda o agrega un nuevo cliente.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══ TARJETAS MOBILE ══ --}}
    <div class="md:hidden flex flex-col gap-3">
        @forelse($clients as $client)
            <div class="rounded-2xl p-4 space-y-3" style="background:#0d1117; border:1.5px solid #1f2937;">
                <div class="flex items-center justify-between gap-3 pb-2.5 border-b border-gray-800">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                            style="background:rgba(0,198,182,.08); border:1px solid rgba(0,198,182,.18);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-white text-sm truncate">{{ $client->full_name }}</div>
                            <div class="text-[10px] text-gray-500 font-mono">{{ $client->rut_dni ?: 'Sin RUT' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button" wire:click="editClient({{ $client->id }})"
                            class="p-2 rounded-lg bg-gray-800 text-gray-300 text-xs font-bold border border-gray-700">
                            ✏️
                        </button>
                        <button type="button" wire:click="deleteClient({{ $client->id }})"
                            wire:confirm="¿Deseas eliminar este cliente?"
                            class="p-2 rounded-lg bg-red-950/40 text-red-400 text-xs font-bold border border-red-800/40">
                            🗑️
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="block text-[10px] font-bold text-gray-500 uppercase">Teléfono</span>
                        <span class="text-gray-300 font-medium">{{ $client->phone }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-gray-500 uppercase">Órdenes</span>
                        @if($client->work_orders_count > 0)
                            <button wire:click="viewOrders({{ $client->id }})" class="text-blue-400 font-bold text-xs underline">
                                Ver {{ $client->work_orders_count }} OT(s)
                            </button>
                        @else
                            <span class="text-gray-600">-</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl p-6 text-center text-gray-500" style="background:#0d1117; border:1.5px solid #1f2937;">
                No se encontraron clientes.
            </div>
        @endforelse
    </div>

    {{-- ══ MODAL: AGREGAR / EDITAR CLIENTE ══ --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    style="background:#0d1117; border:1.5px solid #1f2937;">

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-5">
                        <h3 class="text-base font-black text-white flex items-center gap-2" id="modal-title">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#2dd4bf;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            <span>{{ $editingClientId ? 'Editar Cliente' : 'Agregar Nuevo Cliente' }}</span>
                        </h3>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="p-1.5 rounded-xl text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveClient" class="space-y-4">
                        <!-- Selector Tipo de Cliente -->
                        <div class="flex bg-gray-900 p-1 rounded-2xl border border-gray-800 mb-4">
                            <button type="button" wire:click="$set('is_company', false)" 
                                class="flex-1 py-2 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 {{ !$is_company ? 'bg-orange-600 text-white shadow-md' : 'text-gray-400 hover:text-white' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Persona Natural
                            </button>
                            <button type="button" wire:click="$set('is_company', true)" 
                                class="flex-1 py-2 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 {{ $is_company ? 'bg-orange-600 text-white shadow-md' : 'text-gray-400 hover:text-white' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Empresa (B2B)
                            </button>
                        </div>

                        @if($is_company)
                        <!-- Campos Empresa -->
                        <div class="space-y-4 bg-orange-950/20 p-4 rounded-2xl border border-orange-500/20">
                            <div>
                                <label class="block text-xs font-bold text-orange-400 uppercase tracking-widest mb-1.5">Razón Social / Nombre Empresa *</label>
                                <input wire:model="company_name" type="text" placeholder="Ej: Inversiones & Servicios SpA" required
                                    class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                    style="background:#111827; border:1.5px solid #1f2937;"
                                    onfocus="this.style.borderColor='#f97316';" onblur="this.style.borderColor='#1f2937';">
                                @error('company_name') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Giro Comercial</label>
                                    <input wire:model="business_activity" type="text" placeholder="Ej: Servicios Informáticos"
                                        class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                        style="background:#111827; border:1.5px solid #1f2937;">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Comuna</label>
                                    <input wire:model="commune" type="text" placeholder="Ej: Providencia"
                                        class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                        style="background:#111827; border:1.5px solid #1f2937;">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Dirección Tributaria</label>
                                <input wire:model="address" type="text" placeholder="Ej: Av. Providencia 1234, Oficina 601"
                                    class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                    style="background:#111827; border:1.5px solid #1f2937;">
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">
                                {{ $is_company ? 'Nombre de Contacto / Encargado *' : 'Nombre Completo *' }}
                            </label>
                            <input wire:model="full_name" type="text" placeholder="Ej: Carlos Silva Toledo" required
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('full_name') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div x-data>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $is_company ? 'RUT Empresa *' : 'RUT / DNI' }}
                                </label>
                                <template x-if="$wire.rut_dni && $wire.rut_dni.length >= 8">
                                    <span x-text="window.validateRut($wire.rut_dni) ? '✓ RUT Válido' : '✗ RUT Inválido'"
                                        :class="window.validateRut($wire.rut_dni)
                                            ? 'text-emerald-400 bg-emerald-500/10 border-emerald-500/30'
                                            : 'text-amber-400 bg-amber-500/10 border-amber-500/30'"
                                        class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider border"></span>
                                </template>
                            </div>
                            <input wire:model.live="rut_dni" type="text" placeholder="Ej: 76.543.210-K"
                                x-on:input="$el.value = window.formatRut($el.value); $dispatch('input', $el.value)"
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('rut_dni') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">WhatsApp / Teléfono *</label>
                            <input wire:model="phone" type="text" placeholder="Ej: +56987654321" required
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('phone') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Correo Electrónico (Facturación)</label>
                            <input wire:model="email" type="email" placeholder="Ej: contacto@empresa.cl"
                                class="w-full rounded-xl p-3 text-xs font-medium text-white placeholder-gray-600 transition-all focus:outline-none"
                                style="background:#111827; border:1.5px solid #1f2937;"
                                onfocus="this.style.borderColor='#00C6B6';" onblur="this.style.borderColor='#1f2937';">
                            @error('email') <p class="mt-1 text-xs text-red-400 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 mt-6">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-gray-400 transition cursor-pointer"
                                style="background:#111827; border:1.5px solid #1f2937;">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-white transition shadow-lg cursor-pointer"
                                style="background:linear-gradient(135deg,#00C6B6,#2563eb);">
                                {{ $editingClientId ? 'Guardar Cambios' : 'Registrar Cliente' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ══ MODAL: VER ÓRDENES DEL CLIENTE ══ --}}
    @if($showOrdersModal && $selectedClient)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl"
                    style="background:#0d1117; border:1.5px solid #1f2937;">

                    <div class="flex items-center justify-between pb-4 border-b border-gray-800 mb-5">
                        <div>
                            <h3 class="text-base font-black text-white flex items-center gap-2">
                                📋 Historial de Órdenes — {{ $selectedClient->full_name }}
                            </h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Órdenes de trabajo registradas a nombre de este cliente.</p>
                        </div>
                        <button type="button" wire:click="$set('showOrdersModal', false)"
                            class="p-1.5 rounded-xl text-gray-500 hover:text-white hover:bg-gray-800 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Buscador modal --}}
                    <div class="relative mb-4">
                        <input wire:model.live="searchOrders" type="text"
                            placeholder="Buscar por OT, equipo, problema o estado..."
                            class="w-full rounded-xl py-2.5 pl-9 pr-4 text-xs text-white placeholder-gray-600 focus:outline-none"
                            style="background:#111827; border:1.5px solid #1f2937;">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                    </div>

                    {{-- Tabla de Órdenes --}}
                    <div class="rounded-xl overflow-hidden border border-gray-800 custom-scrollbar overflow-x-auto">
                        <table class="w-full text-left text-xs whitespace-nowrap">
                            <thead>
                                <tr class="text-gray-500 font-extrabold uppercase text-[9.5px] tracking-widest border-b"
                                    style="background:#111827; border-color:#1f2937;">
                                    <th class="px-4 py-3">Nº OT</th>
                                    <th class="px-4 py-3">Equipo</th>
                                    <th class="px-4 py-3">Problema Reportado</th>
                                    <th class="px-4 py-3">Estado</th>
                                    <th class="px-4 py-3">Fecha Ingreso</th>
                                    <th class="px-4 py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/60">
                                @forelse($clientOrders as $order)
                                    <tr class="hover:bg-gray-900/30 transition">
                                        <td class="px-4 py-3 font-mono font-bold text-teal-400">
                                            OT-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-4 py-3 text-white">
                                            <div class="font-bold">{{ $order->device_type }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $order->brand_model ?: 'Genérico' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-300 max-w-xs truncate" title="{{ $order->reported_issue }}">
                                            {{ $order->reported_issue }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'Ingresado' => 'background:rgba(14,165,233,.1); color:#38bdf8; border:1px solid rgba(14,165,233,.2);',
                                                    'En Revisión' => 'background:rgba(245,158,11,.1); color:#fbbf24; border:1px solid rgba(245,158,11,.2);',
                                                    'Aprobado' => 'background:rgba(16,185,129,.1); color:#34d399; border:1px solid rgba(16,185,129,.2);',
                                                    'En Reparación' => 'background:rgba(139,92,246,.1); color:#c084fc; border:1px solid rgba(139,92,246,.2);',
                                                    'Listo para Entrega' => 'background:rgba(16,185,129,.15); color:#34d399; border:1px solid rgba(16,185,129,.3);',
                                                    'Entregado' => 'background:rgba(107,114,128,.1); color:#9ca3af; border:1px solid rgba(107,114,128,.2);',
                                                    'Rechazado' => 'background:rgba(239,68,68,.1); color:#fca5a5; border:1px solid rgba(239,68,68,.2);',
                                                ];
                                                $style = $statusColors[$order->status] ?? 'background:#111827; color:#9ca3af; border:1px solid #1f2937;';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9.5px] font-black uppercase tracking-wider" style="{{ $style }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 font-mono text-[10.5px]">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('work-orders.track', $order->uuid) }}" target="_blank"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold transition"
                                                style="background:rgba(0,198,182,.1); border:1px solid rgba(0,198,182,.2); color:#2dd4bf;">
                                                <span>Ver</span> →
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-xs">
                                            No hay órdenes registradas para este cliente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end pt-4 mt-4 border-t border-gray-800">
                        <button type="button" wire:click="$set('showOrdersModal', false)"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-gray-400" style="background:#111827; border:1.5px solid #1f2937;">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
