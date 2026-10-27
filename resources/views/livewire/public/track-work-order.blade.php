<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-6">
    
    <!-- Top Bar & Brand Header -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center gap-3">
            @auth
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 text-xs font-medium transition cursor-pointer">
                <x-ui.icon name="arrow-left" class="w-3.5 h-3.5" />
                <span>Volver</span>
            </a>
            @endauth
            <div class="flex items-center gap-2.5">
                <img src="/images/logo-dark.png" alt="Sointech" class="h-7 w-auto object-contain">
                <div>
                    <span class="text-sm font-bold tracking-tight text-zinc-900 dark:text-zinc-100 uppercase">Sointech</span>
                    <span class="text-[10px] text-zinc-400 block font-medium">Servicio Técnico Especializado</span>
                </div>
            </div>
        </div>

        <button type="button" onclick="window.printContent('receipt-print-template', 'qr-canvas-a4')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 text-xs font-medium transition cursor-pointer shadow-sm">
            <x-ui.icon name="printer" class="w-3.5 h-3.5 text-zinc-400" />
            <span>Imprimir Comprobante PDF</span>
        </button>
    </div>

    <!-- Main OT Summary Card -->
    <x-ui.card class="p-5 sm:p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200 dark:border-zinc-800">
            <div>
                <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider block">Código de Seguimiento</span>
                <span class="text-xl font-bold font-mono text-zinc-900 dark:text-zinc-100 tracking-tight mt-0.5 block">
                    #{{ substr($workOrder->uuid, 0, 8) }}
                </span>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Estado de la Orden</span>
                @php
                    $statusVariants = [
                        'Ingresado' => 'zinc',
                        'En Revisión' => 'blue',
                        'Presupuestado' => 'amber',
                        'Aprobado' => 'orange',
                        'Esperando Repuestos' => 'purple',
                        'Rechazado' => 'red',
                        'En Reparación' => 'blue',
                        'Listo para Entrega' => 'emerald',
                        'Entregado' => 'zinc',
                    ];
                    $variant = $statusVariants[$workOrder->status] ?? 'zinc';
                @endphp
                <x-ui.badge :variant="$variant" class="text-xs px-3 py-1">
                    {{ $workOrder->status }}
                </x-ui.badge>
            </div>
        </div>

        <!-- Device Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Equipo / Dispositivo</span>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-zinc-900 dark:text-zinc-100 text-sm">{{ $workOrder->brand_model }}</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                        {{ $workOrder->device_type_label }}
                    </span>
                </div>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Problema Reportado</span>
                <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $workOrder->reported_issue }}</p>
            </div>
        </div>
    </x-ui.card>

    <!-- Reception Check-in Details & Photos -->
    <x-ui.card class="p-5 sm:p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
            <h2 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Detalles de Recepción (Check-in)</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
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
            <!-- Physical conditions -->
            <div class="space-y-2.5">
                <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider block">Condición Inicial</span>
                <div class="space-y-2">
                    <div class="flex justify-between items-center p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <span class="text-zinc-600 dark:text-zinc-400">¿Enciende?</span>
                        <span class="{{ $turnsOn ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }} font-bold text-xs">
                            {{ $turnsOn ? 'Sí' : 'No' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <span class="text-zinc-600 dark:text-zinc-400">Contacto con Líquido</span>
                        <span class="{{ $liquidContact === 'No' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-500' }} font-bold text-xs">
                            {{ $liquidContact }}
                        </span>
                    </div>
                    @if($aestheticNotes)
                        <div class="p-3 rounded-xl border border-amber-200 dark:border-amber-800/60 bg-amber-50/50 dark:bg-amber-950/20 text-xs">
                            <span class="text-amber-800 dark:text-amber-300 font-semibold block mb-0.5">Detalles Estéticos:</span>
                            <span class="text-amber-900/80 dark:text-amber-200/80">{{ $aestheticNotes }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Checklist (Collapsible) -->
            <div class="space-y-2.5" x-data="{ openChecklist: false }">
                <div class="flex items-center justify-between cursor-pointer group" @click="openChecklist = !openChecklist">
                    <span class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider">Checklist de Funciones</span>
                    <button type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition p-1">
                        <x-ui.icon name="chevron-down" class="w-4 h-4 transform transition-transform duration-200" ::class="openChecklist ? 'rotate-180' : ''" />
                    </button>
                </div>
                
                <div x-show="openChecklist" x-collapse x-cloak>
                    <div class="grid grid-cols-2 gap-1.5 pt-1">
                        @forelse($features as $item => $checked)
                            @if(!in_array($item, ['turns_on', 'liquid_contact', 'aesthetic_notes', 'features']))
                                <div class="flex items-center justify-between p-2 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                                    <span class="truncate text-zinc-600 dark:text-zinc-400 pr-1 text-[11px]">{{ \Illuminate\Support\Str::limit($item, 16) }}</span>
                                    <span class="{{ $checked ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }} font-bold text-[10px]">
                                        {{ $checked ? 'OK' : 'Falla' }}
                                    </span>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-2 text-zinc-400 italic p-2 text-center text-[11px]">Sin checklist registrado.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Reception Photos Carousel -->
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
                class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-3"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 flex items-center gap-2">
                        <x-ui.icon name="camera" class="w-4 h-4 text-zinc-400" />
                        Fotos de Ingreso (Respaldo Check-in)
                    </span>
                    <span class="text-[11px] font-mono text-zinc-500">
                        <span x-text="activeIndex + 1"></span> de <span x-text="photos.length"></span>
                    </span>
                </div>

                <!-- Main Frame -->
                <div 
                    @touchstart="handleTouchStart($event)" 
                    @touchend="handleTouchEnd($event)"
                    class="relative aspect-[16/9] w-full rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-950 flex items-center justify-center select-none"
                >
                    <template x-for="(photo, index) in photos" :key="index">
                        <div 
                            x-show="activeIndex === index"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-98"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0 w-full h-full flex items-center justify-center p-1"
                        >
                            <img 
                                :src="photo.src" 
                                @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                                class="max-w-full max-h-full object-contain cursor-pointer rounded-lg"
                                alt="Foto de ingreso del equipo"
                            />
                        </div>
                    </template>

                    <!-- Navigation arrows -->
                    <button 
                        x-show="photos.length > 1"
                        @click="prev()" 
                        type="button" 
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-zinc-900/80 border border-zinc-700 text-white flex items-center justify-center hover:bg-zinc-800 transition shadow cursor-pointer text-sm font-bold"
                        aria-label="Anterior"
                    >
                        ‹
                    </button>
                    <button 
                        x-show="photos.length > 1"
                        @click="next()" 
                        type="button" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-zinc-900/80 border border-zinc-700 text-white flex items-center justify-center hover:bg-zinc-800 transition shadow cursor-pointer text-sm font-bold"
                        aria-label="Siguiente"
                    >
                        ›
                    </button>

                    <!-- Expand button -->
                    <button 
                        type="button"
                        @click="openGlobalLightbox(photos, activeIndex, 'Fotos de Ingreso (Check-in)')"
                        class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-lg text-[10px] font-medium bg-zinc-900/80 text-zinc-200 border border-zinc-700 hover:bg-zinc-800 transition flex items-center gap-1 backdrop-blur-xs cursor-pointer"
                    >
                        <x-ui.icon name="zoom-in" class="w-3 h-3" />
                        Ampliar
                    </button>
                </div>

                <!-- Thumbnails strip -->
                <div class="flex items-center gap-2 overflow-x-auto py-1 scrollbar-thin">
                    <template x-for="(photo, index) in photos" :key="index">
                        <button 
                            type="button"
                            @click="activeIndex = index; openGlobalLightbox(photos, index, 'Fotos de Ingreso (Check-in)')"
                            :class="activeIndex === index ? 'border-brand-500 ring-2 ring-brand-500/30 opacity-100' : 'border-zinc-200 dark:border-zinc-800 opacity-60 hover:opacity-100'"
                            class="relative w-14 h-14 shrink-0 rounded-lg overflow-hidden border bg-zinc-950 transition cursor-pointer"
                        >
                            <img :src="photo.src" class="w-full h-full object-cover" />
                        </button>
                    </template>
                </div>
            </div>
        @endif
    </x-ui.card>

    <!-- Flash message -->
    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5 animate-fade-in">
            <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Interactive Budget Approval Card -->
    @if($workOrder->status === 'Presupuestado')
        <x-ui.card class="p-5 sm:p-6 space-y-5 border-amber-300/60 dark:border-amber-700/60">
            <div class="flex items-center gap-3 pb-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <x-ui.icon name="receipt" class="w-4 h-4" />
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Presupuesto Estimado de Reparación</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Revisa el desglose y confirma en línea para autorizar el servicio.</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <!-- Labor -->
                <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                    <span>Mano de Obra (Técnico)</span>
                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($workOrder->labor_cost, 0, ',', '.') }}</span>
                </div>
                
                <!-- Parts -->
                @php
                    $partsTotal = $workOrder->parts->sum(function($part) {
                        return $part->pivot->price_at_time * $part->pivot->quantity;
                    });
                    $shippingCost = (float) ($workOrder->shipping_cost ?? 0);
                    $grandTotal = (float) $workOrder->labor_cost + $partsTotal + $shippingCost;
                @endphp
                @if($partsTotal > 0)
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Repuestos e Insumos</span>
                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($partsTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50 space-y-1.5 text-[11px] text-zinc-600 dark:text-zinc-400">
                        @foreach($workOrder->parts as $part)
                            <div class="flex justify-between">
                                <span>• {{ $part->name }} (x{{ $part->pivot->quantity }})</span>
                                <span>${{ number_format($part->pivot->price_at_time * $part->pivot->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($shippingCost > 0)
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Costo de Envío de Repuestos</span>
                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">${{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if($workOrder->down_payment > 0)
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Abonado Previamente</span>
                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">-${{ number_format($workOrder->down_payment, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="border-t border-zinc-200 dark:border-zinc-800 pt-3 flex flex-col gap-1">
                    <div class="flex justify-between text-sm font-bold text-zinc-900 dark:text-zinc-100">
                        <span>Total del Presupuesto</span>
                        <span>${{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] text-zinc-500">
                        <span>Saldo Restante a Retiro</span>
                        <span>${{ number_format(max(0, $grandTotal - $workOrder->down_payment), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Approval actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-3 border-t border-zinc-200 dark:border-zinc-800">
                <button type="button" wire:click="rejectBudget" wire:confirm="¿Estás seguro que deseas RECHAZAR este presupuesto? Tu equipo se devolverá en el estado actual sin reparar." class="w-full py-2.5 px-4 rounded-xl border border-red-200 dark:border-red-900/60 bg-red-50/50 dark:bg-red-950/20 text-red-600 dark:text-red-400 font-medium text-xs hover:bg-red-100 dark:hover:bg-red-900/40 transition cursor-pointer">
                    Rechazar Presupuesto
                </button>
                
                <button type="button" wire:click="approveBudget" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs shadow-sm transition cursor-pointer flex items-center justify-center gap-2">
                    <x-ui.icon name="check" class="w-4 h-4" />
                    <span>Aprobar e Iniciar Reparación</span>
                </button>
            </div>
        </x-ui.card>
    @endif

    <!-- Repair Pipeline Timeline Flow -->
    <x-ui.card class="p-5 sm:p-6 space-y-6">
        <h2 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Etapa de la Reparación</h2>
        
        @php
            $stages = [
                'Ingresado' => ['title' => 'Ingresado', 'desc' => 'Equipo recibido en taller.'],
                'En Revisión' => ['title' => 'En Revisión', 'desc' => 'Diagnóstico técnico.'],
                'Presupuestado' => ['title' => 'Presupuesto', 'desc' => 'Esperando aprobación.'],
                'En Reparación' => ['title' => 'Reparación', 'desc' => 'En mesa de trabajo.'],
                'Listo para Entrega' => ['title' => 'Listo', 'desc' => 'Listo para retiro.'],
            ];

            $currentStatus = $workOrder->status;
            $statusOrder = ['Ingresado', 'En Revisión', 'Presupuestado', 'En Reparación', 'Listo para Entrega'];
            
            if ($currentStatus === 'Aprobado') {
                $currentStatus = 'Presupuestado';
            }
            if ($currentStatus === 'Esperando Repuestos') {
                $currentStatus = 'En Reparación';
            }
            if ($currentStatus === 'Entregado') {
                $currentStatus = 'Listo para Entrega';
            }
            
            $activeIndex = array_search($currentStatus, $statusOrder);
            if ($activeIndex === false) { $activeIndex = 0; }
            $isRechazado = ($workOrder->status === 'Rechazado');
        @endphp

        <!-- Timeline UI -->
        <div class="relative py-2">
            <div class="absolute inset-y-1/2 left-4 right-4 h-0.5 bg-zinc-200 dark:bg-zinc-800 -translate-y-1/2 -z-10"></div>
            <div class="absolute inset-y-1/2 left-4 h-0.5 bg-brand-500 -translate-y-1/2 -z-10 transition-all duration-300" style="width: {{ $isRechazado ? '25' : ($activeIndex * 25) }}%"></div>

            <div class="flex justify-between items-center text-center">
                @foreach($statusOrder as $index => $step)
                    @php
                        $isCompleted = ($index <= $activeIndex) && !$isRechazado;
                        $isCurrent = ($index === $activeIndex) && !$isRechazado;
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold border transition duration-200 {{ $isCompleted ? ($isCurrent ? 'bg-brand-500 border-brand-500 text-white shadow-sm' : 'bg-brand-100 dark:bg-brand-950 border-brand-500 text-brand-600 dark:text-brand-400') : 'bg-white dark:bg-zinc-900 border-zinc-300 dark:border-zinc-700 text-zinc-400' }}">
                            @if($isCompleted && !$isCurrent)
                                <x-ui.icon name="check" class="w-3.5 h-3.5" />
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-[10px] font-medium mt-1.5 {{ $isCompleted ? 'text-zinc-900 dark:text-zinc-100 font-semibold' : 'text-zinc-400' }}">{{ $stages[$step]['title'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        @if($workOrder->status === 'Esperando Repuestos')
            <div class="p-3 rounded-xl border border-purple-200 dark:border-purple-800/60 bg-purple-50/50 dark:bg-purple-950/20 text-purple-800 dark:text-purple-300 text-xs font-medium text-center">
                Tu equipo se encuentra a la espera de repuestos específicos para proceder con la reparación.
            </div>
        @endif

        @if($isRechazado)
            <div class="p-3 rounded-xl border border-red-200 dark:border-red-800/60 bg-red-50/50 dark:bg-red-950/20 text-red-800 dark:text-red-300 text-xs font-medium text-center">
                El presupuesto para esta orden fue rechazado. El equipo no será reparado y está listo para retiro en taller.
            </div>
        @endif
    </x-ui.card>

    <!-- Latest Log Hero Highlight -->
    @if(isset($latestLog) && $latestLog)
        <div class="p-4 sm:p-5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm space-y-2">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Último Avance Registrado</span>
                </div>
                <span class="text-[11px] text-zinc-400 font-mono">
                    {{ $latestLog->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $latestLog->title }}</h3>
            @if($latestLog->notes)
                <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $latestLog->notes }}</p>
            @endif
        </div>
    @endif

    <!-- Technical Logs History (Bitácora de Avances) -->
    <x-ui.card class="p-5 sm:p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
            <h2 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider flex items-center gap-2">
                <x-ui.icon name="history" class="w-4 h-4 text-zinc-400" />
                Bitácora Histórica de Avances
            </h2>
            <button 
                wire:click="toggleSortOrder" 
                type="button"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 text-xs font-medium transition cursor-pointer"
            >
                <x-ui.icon name="arrow-up-down" class="w-3 h-3 text-zinc-400" />
                <span>{{ $sortAsc ? 'Más antiguos primero' : 'Más recientes primero' }}</span>
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
        
        <div class="relative pl-6 border-l-2 border-zinc-200 dark:border-zinc-800 space-y-6">
            @forelse($orderedLogs as $log)
                <div class="relative">
                    <span class="absolute -left-[31px] top-1.5 w-2.5 h-2.5 rounded-full border-2 bg-white dark:bg-zinc-950 {{ $log->status === 'Listo para Entrega' || $log->status === 'Entregado' ? 'border-emerald-500' : ($log->status === 'Rechazado' ? 'border-red-500' : 'border-brand-500') }}"></span>
                    
                    <div class="space-y-1">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-xs font-semibold text-zinc-900 dark:text-zinc-100">{{ $log->title }}</h3>
                            <span class="text-[10px] text-zinc-400 font-mono">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($log->notes)
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed whitespace-pre-wrap">{{ $log->notes }}</p>
                        @endif
                        
                        @if(count($log->images) > 0)
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($log->images as $lIdx => $imgPath)
                                    @php
                                        $gPos = $bIndexMap[$log->id . '_' . $lIdx] ?? 0;
                                    @endphp
                                    <div 
                                        onclick='openGlobalLightbox(@json($allBitacoraPhotos), {{ $gPos }}, "Bitácora de Avances")'
                                        class="relative w-16 h-16 sm:w-20 sm:h-20 shrink-0 aspect-square rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-950 cursor-pointer group hover:border-brand-500 transition duration-150"
                                    >
                                        <img 
                                            src="{{ asset('storage/' . $imgPath) }}" 
                                            loading="lazy"
                                            class="w-full h-full object-cover group-hover:opacity-90 transition rounded-xl"
                                            onerror="this.onerror=null; this.src='/images/logo-dark.png';"
                                            alt="Evidencia del avance"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-xs text-zinc-400 py-2">No se han registrado avances técnicos adicionales para esta orden.</p>
            @endforelse
        </div>
    </x-ui.card>

    <!-- Terms and Conditions Accordion -->
    <div x-data="{ openTerms: false }" class="p-5 sm:p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm space-y-3">
        <div @click="openTerms = !openTerms" class="flex items-center justify-between cursor-pointer select-none">
            <h2 class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 flex items-center gap-2">
                <x-ui.icon name="file-text" class="w-4 h-4 text-zinc-400" />
                Términos, Condiciones Legales y Garantía del Servicio
            </h2>
            <span class="text-xs text-brand-500 font-medium flex items-center gap-1">
                <span x-text="openTerms ? 'Ocultar' : 'Ver Cláusulas'">Ver Cláusulas</span>
                <x-ui.icon name="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" ::class="{ 'rotate-180': openTerms }" />
            </span>
        </div>
        
        <div x-show="openTerms" x-transition class="pt-3 border-t border-zinc-200 dark:border-zinc-800 text-xs text-zinc-600 dark:text-zinc-400 space-y-2 leading-relaxed">
            <ol class="list-decimal pl-4 space-y-1.5 marker:text-zinc-400 marker:font-semibold">
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
