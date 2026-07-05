<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo de Caja #{{ $register->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; margin: 0; padding: 10px; width: 80mm; color: #000; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-4 { margin-top: 16px; }
        .border-b { border-bottom: 1px dashed #000; padding-bottom: 4px; margin-bottom: 4px; }
        .flex { display: flex; justify-content: space-between; }
        .uppercase { text-transform: uppercase; }
        @media print {
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="text-center font-bold mb-4 uppercase">
        @if(isset($appSettings) && $appSettings->logo_path)
            <img src="{{ Storage::url($appSettings->logo_path) }}" alt="Logo" style="max-width: 120px; max-height: 60px; margin-bottom: 8px; filter: grayscale(100%) contrast(1.2);">
            <br>
        @else
            === SISTEMA SOINTECH ===<br>
        @endif
        ARQUEO DE CAJA
    </div>

    <div class="mb-4">
        <div class="flex"><span>N° Cierre:</span> <span>{{ $register->id }}</span></div>
        <div class="flex"><span>Fecha:</span> <span>{{ $register->closed_at ? $register->closed_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span></div>
        <div class="flex"><span>Cajero:</span> <span>{{ $register->user->name }}</span></div>
    </div>

    <div class="font-bold border-b uppercase mb-2">RESUMEN DEL DÍA</div>
    
    <div class="flex"><span>Base Inicial:</span> <span>${{ number_format($register->opening_balance, 0, ',', '.') }}</span></div>
    <div class="flex mt-4 border-b font-bold"><span>Total Esperado Sistema:</span> <span>${{ number_format($register->expected_closing_balance, 0, ',', '.') }}</span></div>
    
    <div class="mb-4 mt-2">
        <div class="flex"><span>- Efectivo Esp:</span> <span>${{ number_format($register->expected_cash, 0, ',', '.') }}</span></div>
        <div class="flex"><span>- Transf. Esp:</span> <span>${{ number_format($register->expected_transfer, 0, ',', '.') }}</span></div>
        <div class="flex border-b"><span>- Tarjeta Esp:</span> <span>${{ number_format($register->expected_card, 0, ',', '.') }}</span></div>
    </div>

    <div class="font-bold border-b uppercase mb-2 mt-4">CONTABILIZADO FÍSICO (CUADRE)</div>
    
    <div class="flex"><span>- Efectivo Real:</span> <span>${{ number_format($register->closing_cash, 0, ',', '.') }}</span></div>
    <div class="flex"><span>- Transf. Real:</span> <span>${{ number_format($register->closing_transfer, 0, ',', '.') }}</span></div>
    <div class="flex border-b"><span>- Tarjeta Real:</span> <span>${{ number_format($register->closing_card, 0, ',', '.') }}</span></div>
    
    <div class="flex font-bold mt-2"><span>TOTAL CONTABILIZADO:</span> <span>${{ number_format($register->closing_balance, 0, ',', '.') }}</span></div>
    
    @php
        $diferencia = $register->closing_balance - $register->expected_closing_balance;
    @endphp
    <div class="flex font-bold mt-2">
        <span>DIFERENCIA:</span> 
        <span>{{ $diferencia > 0 ? '+' : '' }}${{ number_format($diferencia, 0, ',', '.') }}</span>
    </div>

    @if($register->notes)
        <div class="mt-4 border-b">
            <span class="font-bold">NOTAS/OBSERVACIONES:</span><br>
            {{ $register->notes }}
        </div>
    @endif

    <div class="text-center mt-4 border-b pb-4">
        <br><br><br>
        _______________________<br>
        Firma Responsable
    </div>

    <div class="text-center mt-4 font-bold text-xs">
        * Documento Interno de Arqueo *
    </div>
</body>
</html>
