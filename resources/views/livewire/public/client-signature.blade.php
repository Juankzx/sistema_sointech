<div class="min-h-screen bg-gray-950 text-gray-200 py-8 px-4 font-sans selection:bg-blue-500/30">
    <div class="max-w-md mx-auto relative">

        <!-- Decoración de fondo -->
        <div class="absolute -top-24 -left-20 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-20 w-72 h-72 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

        @if($status === 'expired')
            <div class="bg-gray-900 border border-gray-700 rounded-3xl p-8 text-center shadow-2xl relative z-10 animate-fade-in">
                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-2">Sesión Expirada</h2>
                <p class="text-gray-400 text-sm">El tiempo para firmar este documento ha finalizado o la orden ya fue procesada. Por favor, solicita al técnico que genere un nuevo código QR.</p>
            </div>
        @elseif($status === 'signed')
            <div class="bg-gray-900 border border-gray-700 rounded-3xl p-8 text-center shadow-2xl relative z-10 animate-fade-in">
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-2">¡Firma Recibida!</h2>
                <p class="text-gray-400 text-sm">Tu firma ha sido registrada exitosamente en el sistema. Puedes devolver el equipo al técnico o cerrar esta pantalla.</p>
            </div>
        @else
            <form wire:submit.prevent="submitSignature" class="space-y-6 relative z-10 animate-fade-in">
                
                <div class="text-center space-y-1 mb-8">
                    <h1 class="text-2xl font-black text-white tracking-tight">Acuerdo de Servicio</h1>
                    <p class="text-blue-400 font-bold text-sm">Hola {{ explode(' ', $orderData['full_name'])[0] }}, por favor revisa los datos de tu equipo.</p>
                </div>

                <!-- Resumen del Equipo -->
                <div class="bg-gray-900/80 backdrop-blur-md border border-gray-700 rounded-3xl p-5 shadow-xl">
                    <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Datos del Dispositivo
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-gray-800 pb-2">
                            <span class="text-gray-400">Equipo:</span>
                            <span class="font-bold text-white text-right capitalize">{{ $orderData['device_type'] }} • {{ $orderData['brand_model'] }}</span>
                        </div>
                        <div class="flex flex-col border-b border-gray-800 pb-2">
                            <span class="text-gray-400 mb-1">Falla Reportada:</span>
                            <span class="font-bold text-gray-200">{{ $orderData['reported_issue'] }}</span>
                        </div>
                        <div class="flex flex-col border-b border-gray-800 pb-2">
                            <span class="text-gray-400 mb-1">Estado Estético:</span>
                            <span class="font-bold text-gray-200">{{ $orderData['aesthetic_notes'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-800 pb-2">
                            <span class="text-gray-400">Entrega Estimada:</span>
                            <span class="font-bold text-blue-400 text-right">{{ $orderData['estimated_delivery'] }}</span>
                        </div>
                        
                        <div class="pt-2">
                            @if($orderData['budget_type'] === 'pending')
                                <div class="bg-blue-900/20 text-blue-300 p-3 rounded-2xl text-xs font-bold text-center border border-blue-800/30">
                                    Equipo ingresado para Diagnóstico Técnico.
                                </div>
                            @else
                                <div class="flex justify-between items-center bg-gray-800 p-3 rounded-2xl">
                                    <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Presupuesto</span>
                                    <span class="text-xl font-black text-white">${{ number_format($orderData['total'], 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cláusulas Legales de Protección -->
                <div class="bg-gray-900/80 backdrop-blur-md border border-gray-700 rounded-3xl p-5 shadow-xl">
                    <h3 class="text-xs font-black text-red-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Condiciones del Servicio
                    </h3>
                    
                    <div class="h-64 overflow-y-auto pr-2 space-y-4 custom-scrollbar text-xs text-gray-300 leading-relaxed font-medium">
                        <p class="font-bold text-gray-100">Al firmar este documento, declaras estar de acuerdo con las siguientes políticas del taller:</p>
                        
                        <ol class="list-decimal pl-4 space-y-3 marker:text-gray-500 marker:font-bold">
                            <li><strong>Riesgo de Pérdida de Datos:</strong> El cliente asume total responsabilidad de respaldar su información. El taller no se hace responsable por pérdida de fotos, contactos o datos durante la reparación. Si el cliente requiere que el taller realice un respaldo de su información, este servicio debe solicitarse previamente y tendrá un costo adicional estipulado en el presupuesto.</li>
                            
                            <li><strong>Accesorios No Incluidos:</strong> El taller no se hace responsable por la pérdida de accesorios anexos al equipo, tales como carcasas/fundas, chips (Tarjetas SIM) o tarjetas de memoria (MicroSD) que no hayan sido retirados por el cliente al momento del ingreso.</li>
                            
                            <li><strong>Equipos Apagados o Mojados:</strong> Dispositivos que ingresan sin encender o con daño por líquidos tienen riesgo de "muerte súbita" durante la manipulación. El taller no garantiza la reparación y no asume daños si la placa base colapsa.</li>
                            
                            <li><strong>Equipos sin Clave de Desbloqueo:</strong> Si el cliente no provee la contraseña o patrón, el taller no puede probar todas las funciones (cámaras, sensores, audio) antes o después del arreglo. No se aceptan reclamos sobre funciones no probadas.</li>
                            
                            <li><strong>Abandono de Equipo:</strong> Todo equipo que no sea retirado en un plazo de <strong>30 días</strong> desde el aviso de finalización, generará cobro de bodegaje o será considerado abandonado para reciclaje.</li>
                            
                            <li><strong>Garantía Limitada:</strong> {{ $orderData['warranty_text'] }}</li>
                        </ol>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-800">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <div class="flex items-center h-5 mt-0.5">
                                <input type="checkbox" wire:model.live="terms_accepted" class="w-5 h-5 rounded border-gray-600 bg-gray-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-gray-900 cursor-pointer">
                            </div>
                            <span class="text-xs font-bold text-white leading-tight">
                                He leído, comprendido y acepto todas las condiciones descritas y el presupuesto estimado.
                            </span>
                        </label>
                        @error('terms_accepted') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Panel de Firma Digital -->
                <div x-data="signaturePad()" class="bg-gray-900/80 backdrop-blur-md border border-gray-700 rounded-3xl p-5 shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Firma del Cliente
                        </h3>
                        <button type="button" @click="clearPad" class="text-[10px] bg-gray-800 hover:bg-gray-750 text-gray-300 font-bold px-3 py-1.5 rounded-lg transition border border-gray-700">
                            LIMPIAR
                        </button>
                    </div>
                    
                    <div class="bg-white rounded-2xl w-full h-48 relative overflow-hidden border-2 border-dashed border-gray-400 shadow-inner">
                        <canvas id="signature-pad" class="w-full h-full touch-none cursor-crosshair"></canvas>
                        
                        <!-- Mensaje flotante indicativo -->
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-20">
                            <span class="text-2xl font-black text-gray-800 rotate-[-15deg] uppercase tracking-widest">Firma Aquí</span>
                        </div>
                    </div>
                    
                    <div class="mt-2 text-center">
                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Usa tu dedo para firmar</span>
                    </div>

                    @error('signature_base64') <span class="text-red-400 text-xs font-bold mt-2 block text-center">{{ $message }}</span> @enderror
                    
                    <div class="mt-6">
                        <button type="submit" @click="savePad" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 px-6 rounded-2xl text-sm shadow-lg shadow-blue-500/20 transition flex items-center justify-center gap-2 {{ !$terms_accepted ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$terms_accepted ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ACEPTAR Y ENVIAR FIRMA
                        </button>
                    </div>
                </div>

            </form>
        @endif
    </div>

    <!-- Estilos para Scrollbar personalizada -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(31, 41, 55, 0.5); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(75, 85, 99, 0.8); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(107, 114, 128, 1); }
    </style>
</div>
