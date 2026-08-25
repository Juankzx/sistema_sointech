<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Etiqueta Adhesiva OT #{{ strtoupper(substr($order->uuid, 0, 8)) }}</title>
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
        'templateId' => 'sticker-thermal-standalone',
        'order' => $order,
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('sticker-thermal-standalone');
            if (container) {
                container.style.display = 'block';
            }

            setTimeout(function() {
                window.focus();
                window.print();
            }, 250);
        });
    </script>
</body>
</html>
