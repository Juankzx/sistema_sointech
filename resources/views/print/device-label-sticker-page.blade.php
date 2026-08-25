<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Etiqueta Adhesiva OT #{{ strtoupper(substr($order->uuid, 0, 8)) }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @page {
            size: 58mm 40mm;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media print {
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body>

    @include('components.print.device-label-sticker', [
        'templateId' => 'sticker-standalone',
        'order' => $order,
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('sticker-standalone');
            if (container) {
                container.style.display = 'block';
            }

            const qrCanvas = document.getElementById('sticker-standalone-qr');
            if (qrCanvas && qrCanvas.dataset.url && typeof QRious !== 'undefined') {
                try {
                    new QRious({
                        element: qrCanvas,
                        value: qrCanvas.dataset.url,
                        size: 100,
                        level: 'M',
                    });
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
