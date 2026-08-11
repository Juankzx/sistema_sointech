<div class="space-y-8 animate-fade-in pb-12">
    <!-- Header Principal -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-900/80 border border-slate-800 p-6 rounded-3xl shadow-xl backdrop-blur-md">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 flex items-center justify-center text-2xl text-white shadow-lg shadow-orange-500/20 font-black">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-2">
                    Hola, {{ auth()->user()->name }}
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Consulta el estado en vivo, detalles y evolución de tus equipos en el taller.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::find(1)->support_whatsapp ?? '') }}" target="_blank" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600/10 hover:bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-md">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c-.001 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Soporte WhatsApp
            </a>
        </div>
    </div>
    <!-- Summary Metrics -->
    @php
        $total = $clientOrders->count();
        $enProceso = $clientOrders->whereIn('status', ['Ingresado', 'En Revisión', 'Presupuestado', 'Aprobado', 'Esperando Repuestos', 'En Reparación'])->count();
        $listos = $clientOrders->where('status', 'Listo para Entrega')->count();
        $entregados = $clientOrders->where('status', 'Entregado')->count();
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Metric 1 -->
        <div class="bg-slate-900/60 border border-slate-800 p-4.5 rounded-3xl backdrop-blur-sm flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-xl shrink-0">
                📦
            </div>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Total Órdenes</span>
                <p class="text-xl font-black text-white mt-0.5">{{ $total }}</p>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-slate-900/60 border border-slate-800 p-4.5 rounded-3xl backdrop-blur-sm flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-xl shrink-0">
                ⚙️
            </div>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">En Proceso</span>
                <p class="text-xl font-black text-amber-400 mt-0.5 flex items-center gap-1.5">
                    {{ $enProceso }}
                    @if($enProceso > 0)
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-slate-900/60 border border-slate-800 p-4.5 rounded-3xl backdrop-blur-sm flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                🎉
            </div>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Listos p/ Retiro</span>
                <p class="text-xl font-black text-emerald-400 mt-0.5">{{ $listos }}</p>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-slate-900/60 border border-slate-800 p-4.5 rounded-3xl backdrop-blur-sm flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 text-slate-400 flex items-center justify-center text-xl shrink-0">
                ✅
            </div>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Finalizadas</span>
                <p class="text-xl font-black text-slate-300 mt-0.5">{{ $entregados }}</p>
            </div>
        </div>
    </div>

    <!-- Lista Intuitiva de Órdenes de Trabajo -->
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-base font-extrabold text-white tracking-wide uppercase flex items-center gap-2">
                <span>📑 Mis Órdenes de Servicio</span>
                <span class="text-xs bg-slate-800 text-slate-300 px-2.5 py-0.5 rounded-full font-bold border border-slate-700">{{ $total }}</span>
            </h2>
        </div>

        @forelse($clientOrders as $order)
            @php
                // Configuración de iconos por dispositivo
                $deviceLower = strtolower($order->device_type);
                $deviceIcon = '📱';
                if (str_contains($deviceLower, 'notebook') || str_contains($deviceLower, 'laptop') || str_contains($deviceLower, 'macbook')) {
                    $deviceIcon = '💻';
                } elseif (str_contains($deviceLower, 'desktop') || str_contains($deviceLower, 'pc') || str_contains($deviceLower, 'computador')) {
                    $deviceIcon = '🖥️';
                } elseif (str_contains($deviceLower, 'consola') || str_contains($deviceLower, 'ps') || str_contains($deviceLower, 'xbox') || str_contains($deviceLower, 'nintendo')) {
                    $deviceIcon = '🎮';
                } elseif (str_contains($deviceLower, 'tablet') || str_contains($deviceLower, 'ipad')) {
                    $deviceIcon = '📱';
                } elseif (str_contains($deviceLower, 'impresora')) {
                    $deviceIcon = '🖨️';
                }

                // Cálculo de Etapa / Progreso visual (0 a 100%)
                $statusMap = [
                    'Ingresado' => ['step' => 1, 'percent' => 20, 'badge' => 'bg-slate-800 text-slate-300 border-slate-700', 'icon' => '📥'],
                    'En Revisión' => ['step' => 2, 'percent' => 40, 'badge' => 'bg-amber-950/60 text-amber-300 border-amber-500/40', 'icon' => '🔍'],
                    'Presupuestado' => ['step' => 2, 'percent' => 50, 'badge' => 'bg-indigo-950/60 text-indigo-300 border-indigo-500/40', 'icon' => '📋'],
                    'Aprobado' => ['step' => 3, 'percent' => 65, 'badge' => 'bg-blue-950/60 text-blue-300 border-blue-500/40', 'icon' => '✅'],
                    'Esperando Repuestos' => ['step' => 3, 'percent' => 70, 'badge' => 'bg-amber-950/60 text-amber-300 border-amber-500/40', 'icon' => '📦'],
                    'En Reparación' => ['step' => 3, 'percent' => 75, 'badge' => 'bg-orange-950/60 text-orange-300 border-orange-500/40', 'icon' => '🛠️'],
                    'Listo para Entrega' => ['step' => 4, 'percent' => 90, 'badge' => 'bg-emerald-950/60 text-emerald-300 border-emerald-500/40 animate-pulse', 'icon' => '🎉'],
                    'Entregado' => ['step' => 4, 'percent' => 100, 'badge' => 'bg-slate-900 text-slate-400 border-slate-800', 'icon' => '📦'],
                    'Rechazado' => ['step' => 0, 'percent' => 0, 'badge' => 'bg-rose-950/60 text-rose-300 border-rose-500/40', 'icon' => '❌'],
                    'Sin Reparación' => ['step' => 0, 'percent' => 0, 'badge' => 'bg-slate-900 text-slate-400 border-slate-800', 'icon' => '🚫'],
                ];
                $stInfo = $statusMap[$order->status] ?? ['step' => 1, 'percent' => 25, 'badge' => 'bg-slate-800 text-slate-300 border-slate-700', 'icon' => '📌'];

                // Presupuesto / Saldo
                $partsCostTotal = $order->parts ? $order->parts->sum(function($p) { return $p->pivot->price_at_time * $p->pivot->quantity; }) : 0;
                $orderTotal = (float)$order->labor_cost + $partsCostTotal;
                $balanceDue = max(0, $orderTotal - (float)$order->down_payment);
            @endphp

            <div class="bg-slate-900/90 border border-slate-800/80 hover:border-slate-700 rounded-3xl p-5 md:p-6 shadow-xl transition-all duration-200 group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    
                    <!-- Columna 1: Dispositivo & Info Principal -->
                    <div class="flex items-start gap-4 flex-1">
                        <div class="w-14 h-14 rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-center text-3xl shrink-0 group-hover:scale-105 transition shadow-inner">
                            {{ $deviceIcon }}
                        </div>

                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-black font-mono tracking-wider rounded-lg uppercase">
                                    OT #{{ substr($order->uuid, 0, 8) }}
                                </span>
                                <span class="px-2.5 py-0.5 bg-slate-800 text-slate-400 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                    {{ $order->device_type }}
                                </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-black text-white truncate tracking-tight">
                                {{ $order->brand_model ?: $order->brand ?: ucfirst($order->device_type) }}
                            </h3>

                            <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">
                                <strong class="text-slate-300 font-semibold">Falla Reportada:</strong> {{ $order->reported_issue }}
                            </p>
                        </div>
                    </div>

                    <!-- Columna 2: Estado y Barra de Progreso -->
                    <div class="lg:w-72 bg-slate-950/60 border border-slate-800/60 p-4 rounded-2xl space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Estado Actual:</span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold border shadow-xs {{ $stInfo['badge'] }}">
                                <span>{{ $stInfo['icon'] }}</span>
                                <span>{{ $order->status }}</span>
                            </span>
                        </div>

                        <!-- Barra de Progreso Gráfica -->
                        <div class="space-y-1">
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden p-0.5 border border-slate-700/50">
                                <div class="bg-gradient-to-r from-orange-500 via-amber-400 to-emerald-400 h-full rounded-full transition-all duration-500" style="width: {{ $stInfo['percent'] }}%;"></div>
                            </div>
                            <div class="flex justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider pt-0.5">
                                <span>Recepción</span>
                                <span>Proceso</span>
                                <span>Entrega</span>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 3: Fechas, Montos y Acción -->
                    <div class="flex flex-col sm:flex-row lg:flex-col sm:items-center lg:items-end justify-between gap-4 border-t lg:border-t-0 border-slate-800/80 pt-4 lg:pt-0 shrink-0">
                        <div class="text-left lg:text-right space-y-1">
                            <div class="text-xs text-slate-400 font-medium">
                                📅 Ingresado: <strong class="text-slate-200">{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                            </div>

                            @if($orderTotal > 0)
                                <div class="flex items-center lg:justify-end gap-2 text-xs">
                                    <span class="text-slate-400">Total:</span>
                                    <strong class="text-white font-mono font-bold">${{ number_format($orderTotal, 0, ',', '.') }}</strong>
                                    @if($balanceDue > 0)
                                        <span class="px-2 py-0.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[10px] font-extrabold rounded-md">
                                            Saldo: ${{ number_format($balanceDue, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-extrabold rounded-md">
                                            Pagado ✓
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('work-orders.track', $order->uuid) }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs font-extrabold rounded-2xl transition-all duration-200 shadow-lg shadow-blue-500/20 hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>Ver Detalle y Seguimiento</span>
                            <span class="text-blue-300">→</span>
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-3xl mx-auto text-slate-400 shadow-inner">
                    📭
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">No tienes órdenes de trabajo registradas</h3>
                    <p class="text-xs text-slate-400 mt-1">Cuando ingreses un equipo a nuestro taller, podrás realizar el seguimiento en vivo desde aquí.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
