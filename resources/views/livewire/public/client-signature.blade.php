<div class="min-h-screen py-8 px-4 font-sans max-w-lg mx-auto">
    <div class="relative space-y-6">

        @if($status === 'expired')
            <x-ui.card class="p-8 text-center space-y-4">
                <div class="w-14 h-14 bg-red-100 dark:bg-red-950/40 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mx-auto">
                    <x-ui.icon name="alert-triangle" class="w-7 h-7" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Sesión Expirada</h2>
                <p class="text-zinc-500 text-xs leading-relaxed">El tiempo para firmar este documento ha finalizado o la orden ya fue procesada. Por favor solicita al técnico generar un nuevo enlace o código QR.</p>
            </x-ui.card>
        @elseif($status === 'signed')
            <x-ui.card class="p-8 text-center space-y-4">
                <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center mx-auto">
                    <x-ui.icon name="check-circle" class="w-7 h-7" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Firma Registrada con Éxito</h2>
                <p class="text-zinc-500 text-xs leading-relaxed">Tu firma y conformidad han sido guardadas en la orden de trabajo. Puedes devolver el dispositivo al técnico o cerrar esta ventana.</p>
            </x-ui.card>
        @else
            <form wire:submit.prevent="submitSignature" class="space-y-5">
                
                <div class="text-center space-y-1">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <img src="/images/logo-dark.png" alt="Sointech" class="h-7 w-auto object-contain">
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Acuerdo de Servicio Técnico</h1>
                    <p class="text-xs text-zinc-500">Estimado/a {{ explode(' ', $orderData['full_name'])[0] }}, confirma las condiciones de ingreso.</p>
                </div>

                <!-- Resumen del Equipo -->
                <x-ui.card class="p-5 space-y-3">
                    <h3 class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider flex items-center gap-1.5 pb-2 border-b border-zinc-200 dark:border-zinc-800">
                        <x-ui.icon name="smartphone" class="w-3.5 h-3.5" />
                        Detalles del Dispositivo
                    </h3>
                    
                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Equipo:</span>
                            <span class="font-semibold text-zinc-900 dark:text-zinc-100 text-right capitalize">{{ $orderData['device_type'] }} • {{ $orderData['brand_model'] }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-zinc-500 mb-0.5">Falla Reportada:</span>
                            <span class="text-zinc-800 dark:text-zinc-200">{{ $orderData['reported_issue'] }}</span>
                        </div>
                        @if(!empty($orderData['aesthetic_notes']))
                            <div class="flex flex-col">
                                <span class="text-zinc-500 mb-0.5">Estado Estético:</span>
                                <span class="text-zinc-800 dark:text-zinc-200">{{ $orderData['aesthetic_notes'] }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Entrega Estimada:</span>
                            <span class="font-medium text-brand-500">{{ $orderData['estimated_delivery'] }}</span>
                        </div>
                        
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-800">
                            @if($orderData['budget_type'] === 'pending')
                                <div class="p-2.5 rounded-lg text-center text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                                    Equipo ingresado para Diagnóstico Técnico.
                                </div>
                            @else
                                <div class="flex justify-between items-center p-2.5 rounded-lg bg-zinc-50 dark:bg-zinc-850/60">
                                    <span class="text-xs text-zinc-500 font-medium">Presupuesto Estimado</span>
                                    <span class="text-base font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($orderData['total'], 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-ui.card>

                <!-- Condiciones del Servicio -->
                <x-ui.card class="p-5 space-y-3">
                    <h3 class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider flex items-center gap-1.5 pb-2 border-b border-zinc-200 dark:border-zinc-800">
                        <x-ui.icon name="file-text" class="w-3.5 h-3.5" />
                        Términos del Servicio
                    </h3>
                    
                    <div class="h-44 overflow-y-auto pr-2 space-y-2 text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed scrollbar-thin">
                        <ol class="list-decimal pl-4 space-y-2 marker:text-zinc-400 marker:font-semibold">
                            <li><strong>Respaldo de Datos:</strong> El cliente asume la responsabilidad de respaldar su información antes de la entrega. El taller no se responsabiliza por pérdida de fotos, contactos o datos durante la manipulación.</li>
                            <li><strong>Accesorios:</strong> El taller no se hace responsable por accesorios adicionales (fundas, memorias MicroSD o Tarjetas SIM) no declaradas en la recepción.</li>
                            <li><strong>Equipos Apagados o Mojados:</strong> Dispositivos con antecedente de sulfatación por líquidos tienen riesgo de fallo progresivo de componentes.</li>
                            <li><strong>Abandono de Equipos:</strong> Equipos no retirados dentro de 30 días posteriores al aviso de finalización podrán ser trasladados a custodia según normativa.</li>
                            <li><strong>Garantía:</strong> {{ $orderData['warranty_text'] ?? 'Garantía legal sobre el trabajo efectuado según boleta.' }}</li>
                        </ol>
                    </div>

                    <div class="pt-3 border-t border-zinc-200 dark:border-zinc-800">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" wire:model.live="terms_accepted" class="mt-0.5 rounded border-zinc-300 text-brand-500 focus:ring-brand-500 cursor-pointer">
                            <span class="text-xs text-zinc-700 dark:text-zinc-300 font-medium leading-snug">
                                He leído, comprendido y acepto las condiciones descritas y el presupuesto estimado.
                            </span>
                        </label>
                        @error('terms_accepted') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </x-ui.card>

                <!-- Panel de Firma Digital -->
                <x-ui.card x-data="signaturePad()" class="p-5 space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-zinc-200 dark:border-zinc-800">
                        <h3 class="text-[11px] font-semibold text-zinc-400 uppercase tracking-wider flex items-center gap-1.5">
                            <x-ui.icon name="edit-3" class="w-3.5 h-3.5" />
                            Firma Digital
                        </h3>
                        <button type="button" @click="clearPad" class="text-[11px] font-medium px-2.5 py-1 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer">
                            Limpiar
                        </button>
                    </div>
                    
                    <div class="bg-white rounded-xl w-full h-44 relative overflow-hidden border border-zinc-300 shadow-inner">
                        <canvas id="signature-pad" class="w-full h-full touch-none cursor-crosshair"></canvas>
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-10">
                            <span class="text-xl font-bold text-zinc-800 uppercase tracking-widest">Firma Aquí</span>
                        </div>
                    </div>
                    
                    <span class="text-[11px] text-zinc-400 block text-center">Firma en el recuadro blanco usando tu dedo o stylus</span>

                    @error('signature_base64') <span class="text-red-500 text-xs mt-1 block text-center">{{ $message }}</span> @enderror
                    
                    <div class="pt-3">
                        <button type="submit" @click="savePad" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-semibold text-white bg-brand-500 hover:bg-brand-600 shadow-sm transition cursor-pointer {{ !$terms_accepted ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$terms_accepted ? 'disabled' : '' }}>
                            <x-ui.icon name="check" class="w-4 h-4" />
                            Confirmar y Enviar Firma
                        </button>
                    </div>
                </x-ui.card>

            </form>
        @endif
    </div>
</div>
