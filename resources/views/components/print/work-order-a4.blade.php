<div id="{{ $templateId }}" class="hidden">
    @php
        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
    @endphp
    <div style="font-family: 'Inter', Arial, sans-serif; color: #111827; padding: 20px 30px; max-width: 800px; margin: 0 auto; background: #fff; box-sizing: border-box; position: relative;">
        
        <!-- Watermark -->
        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0.03; pointer-events: none; z-index: 0; overflow: hidden;">
            @if($settings->logo_path)
                <img src="{{ asset('storage/' . $settings->logo_path) }}" style="width: 70%; object-fit: contain; filter: grayscale(100%);" alt="Watermark">
            @else
                <img src="{{ asset('images/logo-dark.png') }}" style="width: 70%; object-fit: contain; filter: grayscale(100%);" alt="Watermark">
            @endif
        </div>

        <div style="position: relative; z-index: 10;">
            <!-- Header -->
            <table style="width: 100%; border-bottom: 2px solid #111827; padding-bottom: 12px; margin-bottom: 15px;">
                <tr>
                    <td style="width: 60%; vertical-align: middle;">
                        <!-- Logo / Company Name -->
                        @if($settings->logo_path)
                            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="{{ $settings->company_name ?: 'Soin Technology' }}" style="height: 55px; object-fit: contain; margin-bottom: 4px;">
                        @else
                            <img src="{{ asset('images/logo-dark.png') }}" alt="Soin Technology Logo" style="height: 55px; object-fit: contain; margin-bottom: 4px;">
                        @endif
                        <p style="margin: 0; font-size: 14px; font-weight: 800; color: #111827; letter-spacing: 1px; text-transform: uppercase;">{{ $settings->company_name ?: 'Soin Technology' }}</p>
                        <p style="margin: 0; font-size: 11px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Documento de Recepción y Check-in</p>
                    </td>
                <td style="width: 40%; text-align: right; vertical-align: middle;">
                    <div style="display: inline-block; text-align: right;">
                        <p style="margin: 0 0 2px 0; font-size: 10px; text-transform: uppercase; color: #6b7280; font-weight: bold; letter-spacing: 0.5px;">Orden de Trabajo</p>
                        <h2 style="margin: 0; font-size: 24px; color: #111827; font-family: monospace; font-weight: 900; letter-spacing: 1px;">#{{ substr($order->uuid, 0, 8) }}</h2>
                        <p style="margin: 2px 0 0; font-size: 11px; color: #4b5563;"><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Datos Principales -->
        <table style="width: 100%; margin-bottom: 15px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; padding-right: 10px; vertical-align: top;">
                    <div style="background: #f9fafb; padding: 12px; border-radius: 6px; border: 1px solid #e5e7eb; height: 100%; box-sizing: border-box;">
                        <h3 style="margin: 0 0 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #111827; letter-spacing: 0.5px;">Datos del Cliente</h3>
                        <p style="margin: 0 0 4px; font-size: 13px; font-weight: bold; color: #111827;">{{ $order->client->full_name }}</p>
                        <p style="margin: 0 0 4px; font-size: 12px; color: #4b5563;">📞 {{ $order->client->phone }}</p>
                        @if($order->client->rut_dni)
                        <p style="margin: 0 0 4px; font-size: 12px; color: #4b5563;">📄 {{ $order->client->rut_dni }}</p>
                        @endif
                        @if($order->client->email)
                        <p style="margin: 0 0 0; font-size: 12px; color: #4b5563;">✉️ {{ $order->client->email }}</p>
                        @endif
                    </div>
                </td>
                <td style="width: 50%; padding-left: 10px; vertical-align: top;">
                    <div style="background: #f9fafb; padding: 12px; border-radius: 6px; border: 1px solid #e5e7eb; height: 100%; box-sizing: border-box;">
                        <h3 style="margin: 0 0 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #111827; letter-spacing: 0.5px;">Ficha del Equipo</h3>
                        <p style="margin: 0 0 4px; font-size: 14px; font-weight: 900; color: #111827;">{{ $order->brand_model }}</p>
                        <p style="margin: 0 0 4px; font-size: 12px; color: #4b5563;"><strong>Tipo:</strong> <span style="text-transform: capitalize;">{{ $order->device_type }}</span></p>
                        @if($order->imei_serial)
                        <p style="margin: 0 0 4px; font-size: 12px; color: #4b5563;"><strong>Nº Serie/IMEI:</strong> {{ $order->imei_serial }}</p>
                        @endif
                        @if($order->unlock_password)
                        <p style="margin: 0 0 0; font-size: 12px; color: #4b5563;"><strong>Clave/Patrón:</strong> {{ $order->unlock_password }}</p>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Falla y Checklist -->
        <div style="margin-bottom: 15px;">
            <h3 style="margin: 0 0 8px; font-size: 12px; font-weight: 800; text-transform: uppercase; color: #ffffff; background: #111827; padding: 6px 10px; border-radius: 4px; letter-spacing: 0.5px;">Detalles del Ingreso</h3>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; border: 1px solid #e5e7eb;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; background: #f9fafb; width: 30%; font-weight: 700; font-size: 12px; color: #374151;">Falla Reportada:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #111827; font-weight: 600;">{{ $order->reported_issue }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; background: #f9fafb; font-weight: 700; font-size: 12px; color: #374151;">Estado Físico / Estético:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #111827;">{{ $order->checklist['aesthetic_notes'] ?? 'Sin observaciones' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; background: #f9fafb; font-weight: 700; font-size: 12px; color: #374151;">¿Enciende?:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #111827; font-weight: 600;">{{ ($order->checklist['turns_on'] ?? true) ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; background: #f9fafb; font-weight: 700; font-size: 12px; color: #374151;">Posible Contacto con Líquido:</td>
                    <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #111827; font-weight: 600;">{{ $order->checklist['liquid_contact'] ?? 'No' }}</td>
                </tr>
                @if($order->estimated_delivery)
                <tr>
                    <td style="padding: 8px; border-right: 1px solid #e5e7eb; background: #f9fafb; font-weight: 700; font-size: 12px; color: #374151;">Tiempo Est. de Entrega:</td>
                    <td style="padding: 8px; font-size: 12px; font-weight: 800; color: #111827;">{{ $order->estimated_delivery }}</td>
                </tr>
                @endif
            </table>

            <!-- Componentes PC (si aplica) -->
            @if(in_array($order->device_type, ['desktop', 'notebook', 'other']) && $order->components && $order->components->count() > 0)
            <div style="margin-top: 12px;">
                <h4 style="margin: 0 0 6px; font-size: 11px; font-weight: 800; color: #111827; text-transform: uppercase;">Componentes Internos Registrados</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 11px; border: 1px solid #e5e7eb;">
                    <tr style="background: #f3f4f6;">
                        <th style="padding: 6px; border: 1px solid #e5e7eb; text-align: left; color: #374151;">Tipo</th>
                        <th style="padding: 6px; border: 1px solid #e5e7eb; text-align: left; color: #374151;">Marca</th>
                        <th style="padding: 6px; border: 1px solid #e5e7eb; text-align: left; color: #374151;">Modelo / Capacidad</th>
                        <th style="padding: 6px; border: 1px solid #e5e7eb; text-align: left; color: #374151;">Nº Serie</th>
                    </tr>
                    @foreach($order->components as $comp)
                    <tr>
                        <td style="padding: 6px; border: 1px solid #e5e7eb; text-transform: capitalize; font-weight: 600;">{{ $comp->component_type }}</td>
                        <td style="padding: 6px; border: 1px solid #e5e7eb;">{{ $comp->brand ?: '-' }}</td>
                        <td style="padding: 6px; border: 1px solid #e5e7eb;">{{ $comp->model ?: '-' }}</td>
                        <td style="padding: 6px; border: 1px solid #e5e7eb;">{{ $comp->serial_number ?: '-' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
            
            <!-- Checklist Funcional -->
            @if(isset($order->checklist['features']) && count($order->checklist['features']) > 0)
            <div style="margin-top: 12px;">
                <h4 style="margin: 0 0 6px; font-size: 11px; font-weight: 800; color: #111827; text-transform: uppercase;">Pruebas Funcionales Iniciales</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach($order->checklist['features'] as $feature => $status)
                        <div style="width: 32%; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; padding: 4px 6px; font-size: 10px; display: inline-block; box-sizing: border-box;">
                            <span style="color: {{ $status ? '#10b981' : '#ef4444' }}; font-weight: 900; margin-right: 4px; font-size: 11px;">{{ $status ? '✓' : '✗' }}</span>
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Costos y Firma -->
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 60%; vertical-align: top; padding-right: 20px;">
                    <div style="font-size: 8.5px; color: #6b7280; line-height: 1.3; text-align: justify; padding-top: 10px;">
                        <strong style="color: #374151;">Condiciones Legales:</strong><br>
                        {{ \App\Models\Setting::find(1)->warranty_text ?? 'El cliente declara que la información proporcionada es verídica. El taller no se responsabiliza por pérdida de información, se recomienda respaldar datos. Pasados 90 días desde el aviso de retiro, los equipos no reclamados se considerarán abandonados.' }}
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top; text-align: center;">
                    @if($order->signature_path)
                        <img src="{{ asset('storage/' . $order->signature_path) }}" alt="Firma del Cliente" style="max-width: 180px; height: 60px; object-fit: contain; border-bottom: 1px solid #111827; padding-bottom: 4px; margin-bottom: 4px;">
                    @else
                        <div style="height: 60px; border-bottom: 1px solid #111827; margin-bottom: 4px;"></div>
                    @endif
                    <p style="margin: 0; font-size: 11px; font-weight: 800; color: #111827;">Firma Conforme del Cliente</p>
                    <p style="margin: 0; font-size: 10px; color: #4b5563;">{{ $order->client->full_name }}</p>
                </td>
            </tr>
        </table>

        <!-- Footer / QR -->
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #d1d5db; text-align: center;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: left; vertical-align: middle; padding-left: 20px;">
                        <p style="margin: 0 0 5px; font-size: 14px; font-weight: 900; color: #111827; letter-spacing: -0.5px;">Consulta el estado de tu equipo en línea:</p>
                        <p style="margin: 0; font-size: 11px; color: #4b5563; line-height: 1.4;">Escanea el código QR desde tu celular o ingresa al <br>siguiente enlace web para revisar el avance de la reparación.</p>
                        <p style="margin: 8px 0 0; font-size: 11px; color: #111827; font-family: monospace; font-weight: bold; background: #f3f4f6; padding: 4px 8px; border-radius: 4px; display: inline-block;">{{ url('/seguimiento/'.$order->uuid) }}</p>
                    </td>
                    <td style="width: 120px; text-align: right; vertical-align: middle; padding-right: 20px;">
                        <div style="display: inline-block; padding: 4px; background: #fff; border: 2px solid #111827; border-radius: 8px;">
                            <canvas id="{{ $qrCanvasId }}" width="90" height="90" data-url="{{ url('/seguimiento/'.$order->uuid) }}"></canvas>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </div>
</div>
