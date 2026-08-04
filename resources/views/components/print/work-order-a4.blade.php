<div id="{{ $templateId }}" class="hidden">
    @php
        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();

        // 1. Cargar firma en Base64 Data URI (evita problemas de servidor/iframe al imprimir)
        $sigSrc = null;
        if (!empty($order->signature_path)) {
            $sigFullPath = storage_path('app/public/' . $order->signature_path);
            if (file_exists($sigFullPath)) {
                $sigData = base64_encode(file_get_contents($sigFullPath));
                $sigSrc = 'data:image/png;base64,' . $sigData;
            } else {
                $sigSrc = asset('storage/' . $order->signature_path);
            }
        }

        // 2. Cargar logo negro (logo-dark.png) en Base64 Data URI
        $logoSrc = null;
        if (!empty($settings->logo_path)) {
            $logoFullPath = storage_path('app/public/' . $settings->logo_path);
            if (file_exists($logoFullPath)) {
                $logoData = base64_encode(file_get_contents($logoFullPath));
                $mime = mime_content_type($logoFullPath) ?: 'image/png';
                $logoSrc = 'data:' . $mime . ';base64,' . $logoData;
            }
        }
        if (!$logoSrc) {
            $defaultLogoPath = public_path('images/logo-dark.png');
            if (file_exists($defaultLogoPath)) {
                $logoData = base64_encode(file_get_contents($defaultLogoPath));
                $logoSrc = 'data:image/png;base64,' . $logoData;
            }
        }
    @endphp

    <div
        style="font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #111827; padding: 25px 35px; max-width: 800px; margin: 0 auto; background: #ffffff; box-sizing: border-box; position: relative;">

        {{-- Marca de Agua sutil --}}
        <div
            style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0.025; pointer-events: none; z-index: 0; overflow: hidden;">
            @if($logoSrc)
                <img src="{{ $logoSrc }}" style="width: 65%; object-fit: contain; filter: grayscale(100%);" alt="Watermark">
            @endif
        </div>

        <div style="position: relative; z-index: 10;">

            {{-- ══ CABECERA PRINCIPAL ══ --}}
            <table
                style="width: 100%; border-bottom: 2px solid #1f2937; padding-bottom: 14px; margin-bottom: 18px; border-collapse: collapse;">
                <tr>
                    <td style="width: 55%; vertical-align: middle;">
                        <table style="border-collapse: collapse;">
                            <tr>
                                @if($logoSrc)
                                    <td style="vertical-align: middle; padding-right: 12px;">
                                        <div style="background: #0f172a; padding: 6px 10px; border-radius: 10px; display: inline-block;">
                                            <img src="{{ $logoSrc }}" alt="Soin Technology"
                                                style="height: 36px; max-width: 140px; object-fit: contain; display: block;">
                                        </div>
                                    </td>
                                @endif
                                <td style="vertical-align: middle;">
                                    <h1 style="margin: 0; font-size: 16px; font-weight: 900; color: #0f172a; letter-spacing: 0.8px; text-transform: uppercase; line-height: 1.1;">
                                        {{ $settings->company_name ?: 'Soin Technology' }}
                                    </h1>
                                    <p style="margin: 3px 0 0; font-size: 9.5px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">
                                        Documento de Recepción y Check-in
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>



                    <td style="width: 45%; text-align: right; vertical-align: middle;">
                        <div
                            style="display: inline-block; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; text-align: right;">
                            <span
                                style="display: block; font-size: 9.5px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 1px; margin-bottom: 2px;">
                                ORDEN DE TRABAJO
                            </span>
                            <span
                                style="display: block; font-size: 22px; font-weight: 900; font-family: monospace; color: #0f172a; letter-spacing: 0.5px; line-height: 1;">
                                #{{ substr($order->uuid, 0, 8) }}
                            </span>
                            <span
                                style="display: block; font-size: 10.5px; font-weight: 600; color: #475569; margin-top: 4px;">
                                📅 {{ $order->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ══ DATOS DE CLIENTE Y FICHA DE EQUIPO ══ --}}
            <table style="width: 100%; margin-bottom: 16px; border-collapse: collapse;">
                <tr>
                    {{-- Tarjeta Cliente --}}
                    <td style="width: 50%; padding-right: 8px; vertical-align: top;">
                        <div
                            style="background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0; height: 100%; box-sizing: border-box;">
                            <div
                                style="display: flex; align-items: center; gap: 6px; margin-bottom: 6px; padding-bottom: 4px; border-bottom: 1px solid #cbd5e1;">
                                <span
                                    style="font-size: 10px; font-weight: 900; text-transform: uppercase; color: #475569; letter-spacing: 0.8px;">
                                    👤 DATOS DEL CLIENTE
                                </span>
                            </div>
                            <p style="margin: 0 0 5px; font-size: 13px; font-weight: 800; color: #0f172a;">
                                {{ $order->client->full_name }}
                            </p>
                            <p style="margin: 0 0 3px; font-size: 11.5px; color: #334155;">
                                📞 <strong>Teléfono:</strong> {{ $order->client->phone }}
                            </p>
                            @if($order->client->rut_dni)
                                <p style="margin: 0 0 3px; font-size: 11.5px; color: #334155;">
                                    📄 <strong>RUT/DNI:</strong> {{ $order->client->rut_dni }}
                                </p>
                            @endif
                            @if($order->client->email)
                                <p style="margin: 0; font-size: 11.5px; color: #334155; word-break: break-all;">
                                    ✉️ <strong>Email:</strong> {{ $order->client->email }}
                                </p>
                            @endif
                        </div>
                    </td>

                    {{-- Tarjeta Equipo --}}
                    <td style="width: 50%; padding-left: 8px; vertical-align: top;">
                        <div
                            style="background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0; height: 100%; box-sizing: border-box;">
                            <div
                                style="display: flex; align-items: center; gap: 6px; margin-bottom: 6px; padding-bottom: 4px; border-bottom: 1px solid #cbd5e1;">
                                <span
                                    style="font-size: 10px; font-weight: 900; text-transform: uppercase; color: #475569; letter-spacing: 0.8px;">
                                    💻 FICHA DEL EQUIPO
                                </span>
                            </div>
                            <p style="margin: 0 0 5px; font-size: 13.5px; font-weight: 900; color: #0f172a;">
                                {{ $order->brand_model }}
                            </p>
                            <p style="margin: 0 0 3px; font-size: 11.5px; color: #334155;">
                                <strong>Tipo:</strong> <span
                                    style="text-transform: capitalize;">{{ $order->device_type }}</span>
                            </p>
                            @if($order->imei_serial)
                                <p style="margin: 0 0 3px; font-size: 11.5px; color: #334155;">
                                    <strong>IMEI / Serie:</strong> {{ $order->imei_serial }}
                                </p>
                            @endif
                            @if($order->unlock_password)
                                <p style="margin: 0; font-size: 11.5px; color: #334155;">
                                    <strong>Clave / Patrón:</strong> {{ $order->unlock_password }}
                                </p>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ══ DETALLES DEL INGRESO Y CHECKLIST ══ --}}
            <div style="margin-bottom: 16px;">
                <div
                    style="background: #0f172a; color: #ffffff; font-size: 11px; font-weight: 900; text-transform: uppercase; padding: 6px 12px; border-radius: 6px; letter-spacing: 0.8px; margin-bottom: 8px;">
                    DETALLES DEL INGRESO Y ESTADO INICIAL
                </div>

                <table
                    style="width: 100%; border-collapse: collapse; margin-bottom: 10px; border: 1px solid #e2e8f0; font-size: 11.5px;">
                    <tr>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; background: #f8fafc; width: 32%; font-weight: 800; color: #334155;">
                            Falla Reportada:
                        </td>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-weight: 700;">
                            {{ $order->reported_issue }}
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; background: #f8fafc; font-weight: 800; color: #334155;">
                            Estado Físico / Estético:
                        </td>
                        <td style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; color: #334155;">
                            {{ $order->checklist['aesthetic_notes'] ?? 'Sin observaciones' }}
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; background: #f8fafc; font-weight: 800; color: #334155;">
                            ¿Enciende al recibir?:
                        </td>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-weight: 800;">
                            {{ ($order->checklist['turns_on'] ?? true) ? 'Sí ✓' : 'No ✗' }}
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; background: #f8fafc; font-weight: 800; color: #334155;">
                            Contacto con Líquido:
                        </td>
                        <td
                            style="padding: 7px 10px; border-bottom: 1px solid #e2e8f0; color: #0f172a; font-weight: 700;">
                            {{ $order->checklist['liquid_contact'] ?? 'No' }}
                        </td>
                    </tr>
                    @if($order->estimated_delivery)
                        <tr>
                            <td
                                style="padding: 7px 10px; border-right: 1px solid #e2e8f0; background: #f8fafc; font-weight: 800; color: #334155;">
                                Tiempo Est. Entrega:
                            </td>
                            <td style="padding: 7px 10px; font-weight: 900; color: #0f172a;">
                                {{ $order->estimated_delivery }}
                            </td>
                        </tr>
                    @endif
                </table>

                {{-- Componentes PC (si aplica) --}}
                @if(in_array($order->device_type, ['desktop', 'notebook', 'other']) && $order->components && $order->components->count() > 0)
                    <div style="margin-top: 10px;">
                        <span
                            style="display: block; margin-bottom: 5px; font-size: 10px; font-weight: 900; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">
                            COMPONENTES DE HARDWARE REGISTRADOS
                        </span>
                        <table
                            style="width: 100%; border-collapse: collapse; font-size: 10.5px; border: 1px solid #e2e8f0;">
                            <tr style="background: #f1f5f9; color: #334155; font-weight: 800; text-transform: uppercase;">
                                <th style="padding: 5px 8px; border: 1px solid #e2e8f0; text-align: left;">Tipo</th>
                                <th style="padding: 5px 8px; border: 1px solid #e2e8f0; text-align: left;">Marca</th>
                                <th style="padding: 5px 8px; border: 1px solid #e2e8f0; text-align: left;">Modelo /
                                    Especificaciones</th>
                                <th style="padding: 5px 8px; border: 1px solid #e2e8f0; text-align: left;">Nº Serie</th>
                            </tr>
                            @foreach($order->components as $comp)
                                <tr>
                                    <td
                                        style="padding: 5px 8px; border: 1px solid #e2e8f0; text-transform: capitalize; font-weight: 700; color: #0f172a;">
                                        {{ $comp->component_type }}</td>
                                    <td style="padding: 5px 8px; border: 1px solid #e2e8f0; color: #475569;">
                                        {{ $comp->brand ?: '-' }}</td>
                                    <td style="padding: 5px 8px; border: 1px solid #e2e8f0; color: #475569;">
                                        {{ $comp->model ?: '-' }}</td>
                                    <td
                                        style="padding: 5px 8px; border: 1px solid #e2e8f0; color: #475569; font-family: monospace;">
                                        {{ $comp->serial_number ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif

                {{-- Pruebas Funcionales Iniciales --}}
                @if(isset($order->checklist['features']) && count($order->checklist['features']) > 0)
                    <div style="margin-top: 10px;">
                        <span
                            style="display: block; margin-bottom: 5px; font-size: 10px; font-weight: 900; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">
                            PRUEBAS FUNCIONALES INICIALES
                        </span>
                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                            @foreach($order->checklist['features'] as $feature => $status)
                                <div
                                    style="width: 32%; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 10px; display: inline-block; box-sizing: border-box;">
                                    <span
                                        style="color: {{ $status ? '#16a34a' : '#dc2626' }}; font-weight: 900; margin-right: 4px; font-size: 11px;">
                                        {{ $status ? '✓' : '✗' }}
                                    </span>
                                    <span style="color: #334155; font-weight: 600;">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- ══ CONDICIONES LEGALES Y FIRMA COMPROBADA ══ --}}
            <table style="width: 100%; margin-top: 14px; border-collapse: collapse;">
                <tr>
                    {{-- Términos Legales --}}
                    <td style="width: 60%; vertical-align: top; padding-right: 14px;">
                        <div
                            style="font-size: 8px; color: #475569; line-height: 1.3; text-align: justify; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px;">
                            <strong
                                style="color: #0f172a; text-transform: uppercase; font-size: 8.5px; display: block; margin-bottom: 4px; border-bottom: 1px solid #cbd5e1; padding-bottom: 2px;">
                                ⚖️ Condiciones del Servicio, Notificación y Abandono:
                            </strong>
                            • <strong>RESPALDO DE DATOS:</strong> El cliente es responsable exclusivo de hacer copia de sus datos. La empresa NO responde por pérdida de archivos o información.<br>
                            • <strong>EQUIPOS APAGADOS:</strong> No se asume responsabilidad por fallas ocultas no verificables si el equipo ingresa sin encender.<br>
                            • <strong>NOTIFICACIÓN FORMAL:</strong> El envío de avisos vía WhatsApp, llamada o e-mail al contacto registrado se considerará notificación válida y formal de retiro.<br>
                            • <strong>BODEGAJE Y ABANDONO (Ley 19.496):</strong> Pasados 30 días del aviso de retiro se aplicará recargo por bodegaje. Transcurridos <strong>90 días corridos</strong> sin retirar el equipo ni responder avisos, el bien se considerará <strong>DECLARADO ABANDONADO</strong> y SOIN TECHNOLOGY dispondrá del bien para cubrir repuestos, servicios y bodegaje adeudados.<br>
                            • <strong>GARANTÍA 90 DÍAS:</strong> Cubre solo la falla reparada y repuestos instalados. Queda nula si se rompen los sellos, por líquidos, golpes o intervención de terceros.
                        </div>
                    </td>

                    {{-- Recuadro de Firma del Cliente --}}
                    <td style="width: 40%; vertical-align: top; text-align: center;">
                        <div
                            style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 8px 12px; min-height: 110px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; box-sizing: border-box;">

                            {{-- Imagen de la Firma en Base64 Data URI --}}
                            @if($sigSrc)
                                <div
                                    style="height: 60px; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="{{ $sigSrc }}" alt="Firma Conforme"
                                        style="max-height: 55px; max-width: 180px; object-fit: contain; display: block;">
                                </div>
                            @else
                                <div
                                    style="height: 60px; width: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; font-style: italic;">
                                    ____________________________________<br>
                                    Firma Física del Cliente
                                </div>
                            @endif

                            <div
                                style="width: 100%; border-top: 1.5px solid #0f172a; padding-top: 3px; margin-top: 4px;">
                                <p style="margin: 0; font-size: 10px; font-weight: 900; color: #0f172a;">
                                    Aceptación Conforme del Cliente
                                </p>
                                <p style="margin: 1px 0 0; font-size: 9px; color: #475569; font-weight: 700;">
                                    {{ $order->client->full_name }} @if($order->client->rut_dni)| RUT: {{ $order->client->rut_dni }}@endif
                                </p>
                                <p style="margin: 2px 0 0; font-size: 7.5px; color: #64748b; font-style: italic; line-height: 1.1;">
                                    "Al firmar, el cliente declara haber leído, comprendido y aceptado las condiciones de servicio, garantía y la cláusula de abandono."
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ══ SEGUIMIENTO EN LÍNEA & QR ══ --}}
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1.5px dashed #cbd5e1;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="text-align: left; vertical-align: middle;">
                            <p
                                style="margin: 0 0 3px; font-size: 13px; font-weight: 900; color: #0f172a; letter-spacing: -0.3px;">
                                📲 Consulta el estado de tu equipo en línea en tiempo real:
                            </p>
                            <p style="margin: 0; font-size: 10.5px; color: #475569; line-height: 1.35;">
                                Escanea el código QR desde la cámara de tu celular o ingresa al enlace web a
                                continuación.
                            </p>
                            <div style="margin-top: 6px;">
                                <span
                                    style="font-size: 10px; color: #0f172a; font-family: monospace; font-weight: bold; background: #f1f5f9; border: 1px solid #cbd5e1; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                    {{ url('/seguimiento/' . $order->uuid) }}
                                </span>
                            </div>
                        </td>

                        <td style="width: 100px; text-align: right; vertical-align: middle;">
                            <div
                                style="display: inline-block; padding: 4px; background: #ffffff; border: 1.5px solid #0f172a; border-radius: 10px;">
                                <canvas id="{{ $qrCanvasId }}" width="85" height="85"
                                    data-url="{{ url('/seguimiento/' . $order->uuid) }}"></canvas>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>