{{-- 
    PLANTILLA DE IMPRESIÓN TÉRMICA - ETIQUETA ADHESIVA COMPACTA (58mm x 40mm)
--}}
@props(['templateId', 'order', 'qrCanvasId' => null])

@include('components.print.device-label-sticker', [
    'templateId' => $templateId,
    'order' => $order
])
