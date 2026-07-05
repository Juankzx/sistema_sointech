<div class="mb-5">
    @if (session()->has('success'))
        <div style="background: rgba(16,185,129,0.1); color: var(--success); padding: 1rem; border-radius: 12px; margin-bottom: 1rem; border: 1px solid var(--success);">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="guardar">
        <!-- 1. Cliente -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" width="24" height="24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Datos del Cliente
            </div>
            <div class="form-group">
                <label>Nombre Completo *</label>
                <input type="text" wire:model="cliente.nombre" required placeholder="Ej: Juan Pérez">
            </div>
            <div class="form-group">
                <label>Teléfono (WhatsApp) *</label>
                <input type="text" wire:model="cliente.telefono" required placeholder="+56912345678">
            </div>
            <div class="form-group">
                <label>RUT / DNI</label>
                <input type="text" wire:model="cliente.rut" placeholder="Opcional">
            </div>
        </div>

        <!-- 2. Equipo y Falla -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" width="24" height="24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Equipo a Reparar
            </div>
            <div class="form-group">
                <label>Tipo de Dispositivo</label>
                <select wire:model.live="equipo.tipo">
                    <option value="Smartphone">Smartphone / Tablet</option>
                    <option value="Notebook">Notebook / PC</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label>Marca y Modelo *</label>
                <input type="text" wire:model="equipo.marca_modelo" required placeholder="Ej: iPhone 13 Pro">
            </div>
            <div class="form-group">
                <label>Falla Reportada *</label>
                <textarea wire:model="equipo.falla" required placeholder="Describe lo que le ocurre al equipo..." rows="3"></textarea>
            </div>
            <div class="flex-between" style="gap:1rem;">
                <div class="form-group" style="flex:1;">
                    <label>Contraseña / Pin</label>
                    <input type="text" wire:model="equipo.clave" placeholder="123456">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>IMEI / Serie</label>
                    <input type="text" wire:model="equipo.imei" placeholder="Opcional">
                </div>
            </div>
        </div>

        <!-- 3. Checklist de Ingreso -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" width="24" height="24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Checklist de Ingreso
            </div>
            <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1rem;">Marca el estado de cada componente al recibir el equipo.</p>
            
            @foreach($checklist as $item => $estado)
            <div style="margin-bottom: 0.8rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom:0.5rem;">
                <div style="font-size:0.9rem; margin-bottom:0.4rem; font-weight:500;">{{ $item }}</div>
                <div class="btn-group">
                    <button type="button" class="btn-check {{ $estado === 'ok' ? 'selected-ok' : '' }}" wire:click="setChecklist('{{ $item }}', 'ok')">OK</button>
                    <button type="button" class="btn-check {{ $estado === 'fail' ? 'selected-fail' : '' }}" wire:click="setChecklist('{{ $item }}', 'fail')">Falla</button>
                    <button type="button" class="btn-check {{ $estado === 'na' ? 'selected-na' : '' }}" wire:click="setChecklist('{{ $item }}', 'na')">N/A</button>
                </div>
            </div>
            @endforeach

            <div class="form-group" style="margin-top:1rem;">
                <label>Observaciones Estéticas</label>
                <textarea wire:model="observaciones_esteticas" placeholder="Rayones en pantalla, trizaduras en tapa trasera..." rows="2"></textarea>
            </div>
        </div>

        <!-- 4. Evidencia y Abono -->
        <div class="card">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" width="24" height="24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Fotografías y Pago
            </div>
            <div class="form-group">
                <label>Tomar Foto del Equipo</label>
                <input type="file" wire:model="fotos_antes" accept="image/*" capture="environment" multiple>
                <div wire:loading wire:target="fotos_antes" style="color:var(--accent-indigo); font-size:0.8rem; margin-top:0.5rem;">Cargando fotos...</div>
            </div>
            <div class="flex-between" style="gap:1rem; margin-top:1rem;">
                <div class="form-group" style="flex:1;">
                    <label>Abono ($)</label>
                    <input type="number" wire:model="abono" min="0" placeholder="0">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Método</label>
                    <select wire:model="metodo_pago">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transfer</option>
                        <option value="Débito/Crédito">Tarjeta</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 5. Firma Digital -->
        <div class="card" x-data="signaturePad()">
            <div class="card-header">
                <svg fill="none" stroke="currentColor" width="24" height="24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Firma del Cliente
            </div>
            
            <p class="legal-text">
                "Garantía exclusiva por fallas de funcionamiento de la pieza reemplazada. No cubre daños por golpes, presión, humedad o equipos previamente mojados. Equipos no retirados en 30 días se considerarán abandonados."
            </p>

            <div class="form-group" style="margin-top:1rem; position:relative;">
                <canvas x-ref="canvas" class="signature-pad" width="400" height="200" @touchstart.prevent="startPosition" @touchmove.prevent="draw" @mousedown="startPosition" @mousemove="draw" @mouseup="endPosition" @mouseleave="endPosition"></canvas>
                <button type="button" @click="clear" style="position:absolute; top:10px; right:10px; background:rgba(239,68,68,0.2); color:var(--danger); border:none; padding:0.4rem 0.8rem; border-radius:6px; font-size:0.75rem;">Limpiar</button>
            </div>
            <input type="hidden" wire:model="firma_base64" x-model="signatureData">

            @error('firma_base64') <span style="color:var(--danger); font-size:0.8rem;">Debes firmar para continuar.</span> @enderror
        </div>

        <button type="submit" class="btn-primary" style="margin-bottom: 2rem;">
            Registrar Orden de Trabajo
        </button>
    </form>

    <script>
        function signaturePad() {
            return {
                signatureData: @entangle('firma_base64'),
                painting: false,
                ctx: null,
                init() {
                    const canvas = this.$refs.canvas;
                    const resizeCanvas = () => {
                        const parent = canvas.parentElement;
                        canvas.width = parent.clientWidth;
                    };
                    window.addEventListener('resize', resizeCanvas);
                    resizeCanvas();

                    this.ctx = canvas.getContext('2d');
                    this.ctx.lineWidth = 3;
                    this.ctx.lineCap = 'round';
                    this.ctx.strokeStyle = '#f8fafc';
                },
                getMousePos(evt) {
                    const rect = this.$refs.canvas.getBoundingClientRect();
                    const clientX = evt.touches ? evt.touches[0].clientX : evt.clientX;
                    const clientY = evt.touches ? evt.touches[0].clientY : evt.clientY;
                    return {
                        x: clientX - rect.left,
                        y: clientY - rect.top
                    };
                },
                startPosition(e) {
                    this.painting = true;
                    this.draw(e);
                },
                endPosition() {
                    this.painting = false;
                    this.ctx.beginPath();
                    this.signatureData = this.$refs.canvas.toDataURL();
                },
                draw(e) {
                    if (!this.painting) return;
                    const pos = this.getMousePos(e);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.stroke();
                    this.ctx.beginPath();
                    this.ctx.moveTo(pos.x, pos.y);
                },
                clear() {
                    this.ctx.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                    this.signatureData = '';
                }
            }
        }
    </script>
</div>
