<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Imprimir Etiqueta Térmica OT #{{ substr($order->uuid, 0, 8) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @page { size: 80mm auto; margin: 0mm; }
        html, body { width: 80mm; max-width: 80mm; margin: 0 auto; padding: 2mm; background: #fff; color: #000; font-family: "Inter", sans-serif; font-size: 11px; line-height: 1.2; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .thermal-ticket-container { width: 100% !important; max-width: 76mm !important; margin: 0 auto !important; padding: 0 !important; }
    </style>
</head>
<body class="bg-white text-black p-0">

    @include('components.print.work-order-thermal', ['templateId' => 'thermal-print-standalone', 'order' => $order, 'qrCanvasId' => 'qr-canvas-standalone'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('thermal-print-standalone');
            if (container) {
                container.classList.remove('hidden');
                container.style.display = 'block';
            }
            const qrCanvas = document.getElementById('qr-canvas-standalone');
            if (qrCanvas && qrCanvas.dataset.url && typeof QRious !== 'undefined') {
                try {
                    new QRious({ element: qrCanvas, value: qrCanvas.dataset.url, size: 110 });
                } catch(e) {}
            }
            setTimeout(function() {
                window.focus();
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
