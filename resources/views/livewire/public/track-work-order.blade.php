<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-8 animate-fade-in relative overflow-hidden">
    
    <!-- Background glows for public premium visual appeal -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -z-10"></div>

    <!-- Header Logo and Service Info -->
    <div class="flex flex-col items-center text-center space-y-3 relative">
        <div class="absolute left-0 top-0 hidden sm:block">
            @auth
            <a href="{{ route('dashboard') }}" class="bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-4 rounded-xl border border-gray-700 shadow flex items-center gap-2 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
            @endauth
        </div>
        <div class="absolute right-0 top-0 hidden sm:block">
            <button onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')" class="bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-4 rounded-xl border border-gray-700 shadow flex items-center gap-2 transition cursor-pointer">
                📄 Descargar / Imprimir PDF
            </button>
        </div>
        <div class="h-14 flex items-center justify-center">
            <img src="/images/logo-dark.png" alt="Sointech Logo" class="h-full w-auto object-contain">
        </div>
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight uppercase">Sointech</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Servicio Técnico Profesional</p>
        </div>
        <div class="sm:hidden mt-2 flex gap-2 justify-center">
            @auth
            <a href="{{ route('dashboard') }}" class="bg-gray-800 hover:bg-gray-700 text-white text-[10px] font-bold py-1.5 px-3 rounded-xl border border-gray-700 shadow flex items-center gap-1.5 transition cursor-pointer">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
            @endauth
            <button onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')" class="bg-gray-800 hover:bg-gray-700 text-white text-[10px] font-bold py-1.5 px-3 rounded-xl border border-gray-700 shadow flex items-center gap-1.5 transition cursor-pointer">
                📄 Imprimir PDF
            </button>
        </div>
    </div>

    <!-- Main OT Summary Card -->
    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-gray-800 shadow-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800/80">
            <div>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Código de Seguimiento</span>
                <span class="text-xl font-extrabold text-orange-400 font-mono mt-1 block uppercase">
                    #{{ substr($workOrder->uuid, 0, 8) }}
                </span>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Estado Actual</span>
                @php
                    $statusColors = [
                        'Ingresado' => 'bg-gray-800 text-gray-400 border-gray-700',
                        'En Revisión' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                        'Presupuestado' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                        'Aprobado' => 'bg-orange-950/40 text-orange-400 border-orange-500/20',
                        'Esperando Repuestos' => 'bg-amber-950/40 text-amber-400 border-amber-500/20',
                        'Rechazado' => 'bg-red-950/40 text-red-400 border-red-500/20 animate-pulse',
                        'En Reparación' => 'bg-indigo-950/40 text-indigo-400 border-indigo-500/20',
                        'Listo para Entrega' => 'bg-emerald-950/40 text-emerald-400 border-emerald-500/20',
                        'Entregado' => 'bg-purple-950/40 text-purple-400 border-purple-500/20',
                    ];
                    $color = $statusColors[$workOrder->status] ?? 'bg-gray-800 text-gray-300';
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-extrabold border mt-1.5 {{ $color }}">
                    {{ $workOrder->status }}
                </span>
            </div>
        </div>

        <!-- Device Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <span class="text-xs text-gray-500 font-semibold uppercase block">Equipo / Dispositivo</span>
                <div class="flex items-center gap-2 flex-wrap mt-1">
                    <span class="font-bold text-white text-base leading-tight">{{ $workOrder->brand_model }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-blue-950/80 text-blue-300 border border-blue-500/30">
                        {{ $workOrder->device_type_label }}
                    </span>
                </div>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-semibold uppercase block">Problema Reportado</span>
                <span class="text-gray-200 mt-1 block leading-snug">{{ $workOrder->reported_issue }}</span>
            </div>
        </div>
    </div>

    <!-- INITIAL CHECKLIST & CONDITION CARD -->
    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-gray-800 shadow-2xl space-y-6">
        <div class="flex items-center gap-2 pb-4 border-b border-gray-800/80">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Detalles de Recepción (Check-in)</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
            @php
                $checklistData = is_array($workOrder->checklist) ? $workOrder->checklist : (json_decode($workOrder->checklist, true) ?? []);
                $turnsOn = $checklistData['turns_on'] ?? true;
                $liquidContact = $checklistData['liquid_contact'] ?? 'No';
                $aestheticNotes = $checklistData['aesthetic_notes'] ?? null;
                $features = $checklistData['features'] ?? [];
                
                if (empty($features) && !empty($checklistData) && !isset($checklistData['features'])) {
                    $features = $checklistData;
                }
            @endphp
            <!-- Condiciones Físicas -->
            <div class="space-y-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Estado Físico al Ingreso</span>
                <div class="space-y-2 text-gray-300">
                    <div class="flex justify-between items-center bg-gray-950/50 p-2.5 rounded-xl border border-gray-800/60">
                        <span>¿El equipo enciende?</span>
                        <span class="{{ $turnsOn ? 'text-emerald-400' : 'text-red-400' }} font-bold text-xs uppercase">
                            {{ $turnsOn ? '✓ Sí' : '✗ No' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-950/50 p-2.5 rounded-xl border border-gray-800/60">
                        <span>Contacto c/ Líquido</span>
                        <span class="{{ $liquidContact === 'No' ? 'text-emerald-400' : 'text-orange-400' }} font-bold text-xs uppercase">
                            {{ $liquidContact }}
                        </span>
                    </div>
                    @if($aestheticNotes)
                        <div class="bg-orange-950/30 p-3 rounded-xl border border-orange-500/20 text-xs mt-2">
                            <span class="text-orange-400 font-bold block mb-1">Notas Estéticas (Marcas/Rayones):</span>
                            {{ $aestheticNotes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Checklist Técnico (Collapsible) -->
            <div class="space-y-3" x-data="{ openChecklist: false }">
                <div class="flex items-center justify-between cursor-pointer group" @click="openChecklist = !openChecklist">
                    <span class="text-xs font-semibold text-gray-500 group-hover:text-gray-300 uppercase tracking-wider transition-colors">Checklist Inicial Rápido</span>
                    <button type="button" class="text-gray-500 group-hover:text-white transition-colors bg-gray-800/50 rounded-full p-1 border border-gray-700/50">
                        <svg class="w-4 h-4 transform transition-transform duration-300" :class="openChecklist ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                
                <div x-show="openChecklist" x-collapse x-cloak>
                    <div class="grid grid-cols-2 gap-2 text-xs pt-1">
                        @forelse($features as $item => $checked)
                            @if(!in_array($item, ['turns_on', 'liquid_contact', 'aesthetic_notes', 'features']))
                                <div class="flex items-center justify-between bg-gray-950/50 p-2.5 rounded-lg border border-gray-800/60 transition-colors hover:border-gray-700">
                                    <span class="truncate pr-1 text-gray-400" title="{{ $item }}">{{ \Illuminate\Support\Str::limit($item, 16) }}</span>
                                    <span class="{{ $checked ? 'text-emerald-400' : 'text-red-400' }} font-bold text-[10px] uppercase">
                                        {{ $checked ? '✓ OK' : '✗ Falla' }}
                                    </span>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-2 text-gray-500 italic p-2 text-center text-[10px]">Sin checklist registrado.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- FOTOS DE INGRESO (CARRUSEL INTERACTIVO CHECK-IN) -->
        @if($workOrder->images && $workOrder->images->count() > 0)
            @php
                $checkInList = $workOrder->images->map(fn($img, $idx) => [
                    'src' => asset('storage/' . $img->image_path),
                    'title' => 'Foto de Ingreso #' . ($idx + 1),
                    'caption' => 'Respaldo Fotográfico Check-in (' . ($idx + 1) . '/' . $workOrder->images->count() . ')',
                    'description' => 'Fotografía del estado físico del equipo tomada durante la recepción (Check-in).'
                ])->values()->toArray();
            @endphp
            <div 
                x-data="{ 
                    activeIndex: 0, 
                    photos: {{ json_encode($checkInList) }},
                    next() { this.activeIndex = (this.activeIndex + 1) % this.photos.length },
                    prev() { this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length },
                    touchStartX: 0,
                    touchEndX: 0,
                    handleTouchStart(e) { this.touchStartX = e.changedTouches[0].screenX },
                    handleTouchEnd(e) { 
                        this.touchEndX = e.changedTouches[0].screenX;
                        if (this.touchStartX - this.touchEndX > 35) this.next();
                        if (this.touchEndX - this.touchStartX > 35) this.prev();
                    }
                }" 
                class="pt-4 border-t border-gray-800/80 space-y-3"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-400 uppercase tracking-wider flex items-center gap-2">
                        📸 Fotos de Ingreso del Equipo (Respaldo Check-in)
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-950/80 text-blue-300 border border-blue-500/30">
                        <span x-text="activeIndex + 1"></span> / <span x-text="photos.length"></span> {{ $workOrder->images->count() === 1 ? 'imagen' : 'imágenes' }}
                    </span>
                </div>

                <!-- Frame Principal Interactivo -->
                <div 
                    @touchstart="handleTouchStart($event)" 
                    @touchend="handleTouchEnd($event)"
                    class="relative aspect-[4/3] sm:aspect-[16/9] w-full rounded-2xl overflow-hidden border border-gray-800 bg-gray-950 shadow-inner group flex items-center justify-center select-none"
                >
                    <template x-for="(photo, index) in photos" :key="index">
                        <div 
                            x-show="activeIndex === index"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0 w-full h-full flex items-center justify-center p-1"
                        >
                            <img 
                                :src="photo.src" 
                                @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                                class="max-w-full max-h-full object-contain cursor-pointer rounded-xl"
                                alt="Foto de ingreso del equipo"
                            />
                        </div>
                    </template>

                    <!-- Botones de Navegación -->
                    <button 
                        x-show="photos.length > 1"
                        @click="prev()" 
                        type="button" 
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gray-900/80 border border-gray-700 text-white font-bold flex items-center justify-center hover:bg-blue-600 transition shadow-lg z-10 active:scale-90 text-lg"
                        aria-label="Anterior"
                    >
                        ‹
                    </button>
                    <button 
                        x-show="photos.length > 1"
                        @click="next()" 
                        type="button" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gray-900/80 border border-gray-700 text-white font-bold flex items-center justify-center hover:bg-blue-600 transition shadow-lg z-10 active:scale-90 text-lg"
                        aria-label="Siguiente"
                    >
                        ›
                    </button>

                    <!-- Botón Ampliar -->
                    <button 
                        type="button"
                        @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                        class="absolute bottom-2.5 right-2.5 px-3 py-1 rounded-full text-[10px] font-bold bg-black/75 text-gray-200 border border-gray-700 hover:bg-blue-600 hover:text-white transition flex items-center gap-1 backdrop-blur-md shadow-lg"
                    >
                        🔍 Ampliar Foto
                    </button>
                </div>

                <!-- Tira de Miniaturas -->
                <div class="flex items-center gap-2 overflow-x-auto py-2 px-1 custom-scrollbar scroll-smooth">
                    <template x-for="(photo, index) in photos" :key="index">
                        <button 
                            type="button"
                            @click="activeIndex = index; openGlobalLightbox(photos, index, 'Fotos de Ingreso (Check-in)')"
                            :class="activeIndex === index ? 'border-blue-500 ring-2 ring-blue-500/40 scale-105 opacity-100' : 'border-gray-800 opacity-60 hover:opacity-100'"
                            class="relative w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-xl overflow-hidden border bg-gray-950 transition duration-200 cursor-pointer group"
                            title="Ver foto en pantalla completa"
                        >
                            <img :src="photo.src" class="w-full h-full object-cover group-hover:scale-105 transition duration-200" />
                        </button>
                    </template>
                </div>
                <p class="text-[10px] text-gray-400 italic text-center">👈 Toca cualquier miniatura para verla en pantalla completa o desliza para navegar.</p>
            </div>
        @endif
    </div>

    <!-- FLASH MESSAGES -->
    @if (session()->has('message'))
        <div class="bg-green-950/50 border border-green-500/30 text-green-300 px-6 py-5 rounded-3xl shadow-lg flex items-center gap-3 animate-bounce" role="alert">
            <span class="w-2.5 h-2.5 rounded-full bg-green-400 animate-ping"></span>
            <span class="text-sm font-semibold">{{ session('message') }}</span>
        </div>
    @endif

    <!-- INTERACTIVE BUDGET APPROVAL CARD -->
    @if($workOrder->status === 'Presupuestado')
        <div class="bg-gradient-to-r from-gray-900 to-gray-850 rounded-3xl p-6 sm:p-8 border border-yellow-500/20 shadow-2xl relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-yellow-500/5 rounded-full blur-2xl"></div>
            
            <div class="space-y-6">
                <div class="flex items-center gap-2.5 pb-4 border-b border-gray-800/80">
                    <span class="p-2 bg-yellow-500/10 text-yellow-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V5"></path></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-extrabold text-white tracking-tight">Presupuesto Estimado de Reparación</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Por favor, revisa el detalle y aprueba en línea para iniciar el servicio.</p>
                    </div>
                </div>

                <!-- Itemized Cost Details -->
                <div class="space-y-3 text-sm">
                    <!-- Labor Cost -->
                    <div class="flex justify-between text-gray-400">
                        <span>Costo de Mano de Obra (Técnico)</span>
                        <span class="font-bold text-white">${{ number_format($workOrder->labor_cost, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Parts Cost -->
                    @php
                        $partsTotal = $workOrder->parts->sum(function($part) {
                            return $part->pivot->price_at_time * $part->pivot->quantity;
                        });
                    @endphp
                    @if($partsTotal > 0)
                        <div class="flex justify-between text-gray-400">
                            <span>Repuestos e Insumos</span>
                            <span class="font-bold text-white">${{ number_format($partsTotal, 0, ',', '.') }}</span>
                        </div>
                        <!-- List of parts used -->
                        <div class="bg-gray-950/60 p-3.5 rounded-2xl border border-gray-800 space-y-1.5 pl-6 list-disc text-xs text-gray-400">
                            @foreach($workOrder->parts as $part)
                                <div class="flex justify-between">
                                    <span>• {{ $part->name }} (x{{ $part->pivot->quantity }})</span>
                                    <span>${{ number_format($part->pivot->price_at_time * $part->pivot->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($workOrder->down_payment > 0)
                        <div class="flex justify-between text-gray-400">
                            <span>Abonado Previamente</span>
                            <span class="font-bold text-emerald-400">${{ number_format($workOrder->down_payment, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <!-- Grand Total and Balance Due -->
                    <div class="border-t border-gray-800 pt-4 flex flex-col gap-1">
                        <div class="flex justify-between text-base font-bold text-white">
                            <span>Total del Presupuesto</span>
                            <span>${{ number_format($workOrder->labor_cost + $partsTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Saldo Restante a Pagar al Retirar</span>
                            <span>${{ number_format(($workOrder->labor_cost + $partsTotal) - $workOrder->down_payment, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Approval Actions -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-gray-800/80">
                    <button wire:click="rejectBudget" wire:confirm="¿Estás seguro que deseas RECHAZAR este presupuesto? Tu equipo se devolverá en el estado actual sin reparar." class="w-full py-3.5 px-4 rounded-xl border border-red-500/30 hover:border-red-500 bg-red-950/10 text-red-400 font-semibold text-sm transition duration-200 cursor-pointer">
                        Rechazar Presupuesto
                    </button>
                    
                    <button wire:click="approveBudget" class="w-full py-3.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition duration-200 cursor-pointer flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aprobar e Iniciar Reparación
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- REPAIR PIPELINE PROCESS (TIMELINE FLOW) -->
    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-gray-800 shadow-2xl space-y-6">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Etapa de la Reparación</h2>
        
        @php
            $stages = [
                'Ingresado' => ['title' => 'Ingresado', 'desc' => 'Equipo recibido en taller.'],
                'En Revisión' => ['title' => 'En Revisión', 'desc' => 'Técnico diagnosticando el equipo.'],
                'Presupuestado' => ['title' => 'Presupuestado', 'desc' => 'Presupuesto esperando aprobación.'],
                'En Reparación' => ['title' => 'Reparación', 'desc' => 'Manos a la obra, reparando equipo.'],
                'Listo para Entrega' => ['title' => 'Listo para Retiro', 'desc' => 'Reparación finalizada con éxito.'],
            ];

            // Determine active step index
            $currentStatus = $workOrder->status;
            // Map virtual flow to simplify tracking
            $statusOrder = ['Ingresado', 'En Revisión', 'Presupuestado', 'En Reparación', 'Listo para Entrega'];
            
            // Special rules if status is Aprobado (waiting for tech to start)
            if ($currentStatus === 'Aprobado') {
                $currentStatus = 'Presupuestado';
            }
            if ($currentStatus === 'Esperando Repuestos') {
                $currentStatus = 'En Reparación';
            }
            // Special rules if status is Entregado (it means Listo is completed)
            if ($currentStatus === 'Entregado') {
                $currentStatus = 'Listo para Entrega';
            }
            
            $activeIndex = array_search($currentStatus, $statusOrder);
            if ($activeIndex === false) { $activeIndex = 0; } // Fallback
            
            // Special rules if status is Rechazado
            $isRechazado = ($workOrder->status === 'Rechazado');
        @endphp

        <!-- Horizontal Timeline UI -->
        <div class="relative py-4">
            <!-- Line -->
            <div class="absolute inset-y-1/2 left-4 right-4 h-0.5 bg-gray-800 -translate-y-1/2 -z-10"></div>
            <div class="absolute inset-y-1/2 left-4 h-0.5 bg-orange-500 -translate-y-1/2 -z-10 transition-all duration-500" style="width: {{ $isRechazado ? '25' : ($activeIndex * 25) }}%"></div>

            <div class="flex justify-between items-center text-center">
                @foreach($statusOrder as $index => $step)
                    @php
                        $isCompleted = ($index <= $activeIndex) && !$isRechazado;
                        $isCurrent = ($index === $activeIndex) && !$isRechazado;
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border transition duration-300 {{ $isCompleted ? ($isCurrent ? 'bg-orange-600 border-orange-500 text-white shadow-lg shadow-orange-500/30' : 'bg-orange-950 border-orange-500 text-orange-400') : 'bg-gray-900 border-gray-800 text-gray-500' }}">
                            @if($isCompleted && !$isCurrent)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-[10px] font-semibold mt-2 {{ $isCompleted ? 'text-white' : 'text-gray-500' }}">{{ $stages[$step]['title'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        @if($workOrder->status === 'Esperando Repuestos')
            <div class="p-4 bg-amber-950/30 border border-amber-500/30 text-amber-300 rounded-2xl text-xs font-semibold text-center flex items-center justify-center gap-2">
                <span>📦</span>
                <span>Tu equipo se encuentra a la espera de repuestos para proceder con la reparación.</span>
            </div>
        @endif

        @if($isRechazado)
            <div class="p-4 bg-red-950/20 border border-red-500/20 text-red-400 rounded-2xl text-xs font-semibold text-center animate-pulse">
                El presupuesto para esta orden de trabajo fue RECHAZADO. El equipo no será reparado y está listo para retiro.
            </div>
        @endif
    </div>



    <!-- LATEST LOG HERO HIGHLIGHT CARD -->
    @if(isset($latestLog) && $latestLog)
        <div class="bg-gradient-to-r from-blue-950/40 via-indigo-950/30 to-gray-900 border border-blue-500/30 rounded-3xl p-5 sm:p-6 shadow-2xl space-y-3 relative overflow-hidden">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    <span class="text-xs font-black text-blue-400 uppercase tracking-wider">Último Avance Registrado</span>
                </div>
                <span class="text-[10px] font-bold text-gray-400 bg-gray-900/80 px-2.5 py-1 rounded-full border border-gray-800">
                    {{ $latestLog->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
            <h3 class="text-base font-extrabold text-white tracking-tight">{{ $latestLog->title }}</h3>
            @if($latestLog->notes)
                <p class="text-xs text-gray-300 leading-relaxed">{{ $latestLog->notes }}</p>
            @endif
        </div>
    @endif

    <!-- TECHNICAL LOGS HISTORY (BITACORA DE AVANCES) -->
    <div class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-gray-800 shadow-2xl space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-2 pb-2 border-b border-gray-800/80">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                📌 Bitácora Histórica de Avances
            </h2>
            <button 
                wire:click="toggleSortOrder" 
                type="button"
                class="px-3 py-1.5 rounded-xl bg-gray-800/90 hover:bg-gray-750 border border-gray-700/80 text-xs font-bold text-blue-400 hover:text-blue-300 transition duration-150 flex items-center gap-1.5 cursor-pointer shadow-sm active:scale-95"
            >
                @if($sortAsc)
                    <span>⬆️ Más antiguos primero</span>
                @else
                    <span>⬇️ Más recientes primero</span>
                @endif
            </button>
        </div>
        
        @php
            $allBitacoraPhotos = [];
            $bIndexMap = [];
            $gCount = 0;
            foreach($orderedLogs as $logItem) {
                if(count($logItem->images) > 0) {
                    foreach($logItem->images as $lIdx => $imgPath) {
                        $allBitacoraPhotos[] = [
                            'src' => asset('storage/' . $imgPath),
                            'title' => $logItem->title,
                            'description' => $logItem->notes ?? ''
                        ];
                        $bIndexMap[$logItem->id . '_' . $lIdx] = $gCount++;
                    }
                }
            }
        @endphp
        
        <div class="relative pl-6 border-l-2 border-gray-800 space-y-6">
            @forelse($orderedLogs as $log)
                <div class="relative">
                    <!-- Circle Indicator on the line -->
                    <span class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full border bg-gray-950 {{ $log->status === 'Listo para Entrega' || $log->status === 'Entregado' ? 'border-emerald-500 bg-emerald-500/25' : ($log->status === 'Rechazado' ? 'border-red-500 bg-red-500/25' : 'border-orange-500 bg-orange-500/25') }}"></span>
                    
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-sm font-bold text-white leading-snug">{{ $log->title }}</h3>
                            <span class="text-[10px] text-gray-500 font-semibold">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($log->notes)
                            <p class="text-xs text-gray-400 leading-relaxed whitespace-pre-wrap">{{ $log->notes }}</p>
                        @endif
                        
                        @if(count($log->images) > 0)
                            <div class="mt-2.5 flex flex-wrap gap-2.5">
                                @foreach($log->images as $lIdx => $imgPath)
                                    @php
                                        $gPos = $bIndexMap[$log->id . '_' . $lIdx] ?? 0;
                                    @endphp
                                    <div 
                                        onclick='openGlobalLightbox(@json($allBitacoraPhotos), {{ $gPos }}, "Bitácora de Avances")'
                                        class="relative w-20 h-20 sm:w-24 sm:h-24 shrink-0 aspect-square rounded-2xl overflow-hidden border border-gray-700/60 shadow-lg bg-gray-950 cursor-pointer group hover:border-orange-500/50 hover:scale-105 transition duration-300"
                                    >
                                        <img 
                                            src="{{ asset('storage/' . $imgPath) }}" 
                                            loading="lazy"
                                            class="w-full h-full object-cover group-hover:opacity-90 transition rounded-2xl"
                                            onerror="this.onerror=null; this.src='/images/logo-dark.png';"
                                            alt="Evidencia del hito"
                                        >
                                        <span class="absolute top-1 right-1 px-1.5 py-0.5 rounded text-[7px] font-black uppercase bg-gray-950/80 text-orange-400 border border-orange-500/30 backdrop-blur-sm">
                                            Bitácora
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-gray-500 py-2">No se han registrado avances técnicos adicionales para esta orden.</p>
            @endforelse
        </div>
    </div>

    <!-- TERMS AND CONDITIONS / LEGAL POLICIES CARD -->
    <div x-data="{ openTerms: false }" class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-gray-800 shadow-2xl space-y-4">
        <div @click="openTerms = !openTerms" class="flex items-center justify-between cursor-pointer select-none">
            <h2 class="text-sm font-bold text-gray-300 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Términos, Condiciones Legales y Garantía del Servicio
            </h2>
            <span class="text-xs text-blue-400 font-bold flex items-center gap-1">
                <span x-text="openTerms ? 'Ocultar' : 'Ver Cláusulas'">Ver Cláusulas</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openTerms }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </span>
        </div>
        
        <div x-show="openTerms" x-transition class="pt-4 border-t border-gray-800 text-xs text-gray-300 space-y-3 font-medium leading-relaxed">
            <ol class="list-decimal pl-4 space-y-2.5 marker:text-gray-500 marker:font-bold">
                <li><strong>Respaldos de Datos:</strong> El cliente asume la responsabilidad de respaldar su información antes de la entrega. El taller no se responsabiliza por pérdidas de datos durante el proceso técnico.</li>
                <li><strong>Accesorios:</strong> El taller no se hace responsable por accesorios adicionales (fundas, memorias MicroSD o Tarjetas SIM) no declaradas en la recepción.</li>
                <li><strong>Riesgo por Humedad o Apagado:</strong> Dispositivos que ingresen apagados o con antecedente de sulfatación por líquidos conllevan riesgo de fallo progresivo de placa.</li>
                <li><strong>Abandono de Equipos:</strong> Equipos no retirados dentro de 30 días posteriores al aviso de finalización podrán ser trasladados a custodia o reciclaje según normativa.</li>
                <li><strong>Garantía Limitada:</strong> Cobertura exclusiva en la pieza o reparación realizada por fallas de fabricación. Excluye caídas, sulfatación, manipulación por terceros o sellos rotos.</li>
            </ol>
        </div>
    </div>

    <!-- Hidden Print Templates -->
    <div style="display: none;">
        @include('components.print.work-order-a4', ['templateId' => 'receipt-print-template', 'order' => $workOrder, 'qrCanvasId' => 'qr-canvas-a4'])
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script>
        window.printContent = function(elementId, qrCanvasId = 'qr-canvas') {
            const el = document.getElementById(elementId);
            if (!el) { console.error('Elemento no encontrado:', elementId); return; }
            const printContent = el.innerHTML;
            
            const printWindow = window.open('', '_blank', 'height=600,width=800');
            if (!printWindow) {
                alert('Por favor, habilita las ventanas emergentes (pop-ups) en tu navegador para poder imprimir.');
                return;
            }

            printWindow.document.write('<html><head><title>Imprimir Comprobante Sointech</title>');
            printWindow.document.write('<script src="https://cdn.tailwindcss.com"><\/script>');
            printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">');
            printWindow.document.write('<style>');
            printWindow.document.write('  body { font-family: "Inter", sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }');
            printWindow.document.write('  @page { margin: 10mm; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body class="bg-white text-black p-2 flex justify-center items-start">');
            printWindow.document.write('<div class="w-full">' + printContent + '</div>');
            printWindow.document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"><\/script>');
            printWindow.document.write('<script>');
            printWindow.document.write('  window.onload = function() {');
            printWindow.document.write('    const qrCanvas = document.getElementById("' + qrCanvasId + '");');
            printWindow.document.write('    if (qrCanvas && qrCanvas.dataset.url) {');
            printWindow.document.write('      new QRious({');
            printWindow.document.write('        element: qrCanvas,');
            printWindow.document.write('        value: qrCanvas.dataset.url,');
            printWindow.document.write('        size: 150');
            printWindow.document.write('      });');
            printWindow.document.write('    }');
            printWindow.document.write('    setTimeout(function() { window.print(); window.close(); }, 500);');
            printWindow.document.write('  };');
            printWindow.document.write('<\/script>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
        }
    </script>
</div>
