@props([
    'name',
    'class' => 'w-4 h-4',
    'strokeWidth' => '1.75',
])

@php
    $n = strtolower(trim($name));
@endphp

<svg 
    xmlns="http://www.w3.org/2000/svg" 
    viewBox="0 0 24 24" 
    fill="none" 
    stroke="currentColor" 
    stroke-width="{{ $strokeWidth }}" 
    stroke-linecap="round" 
    stroke-linejoin="round" 
    {{ $attributes->merge(['class' => $class]) }}
>
    @switch($n)
        {{-- Dashboard / Home --}}
        @case('dashboard')
        @case('home')
        @case('layout-dashboard')
            <rect width="7" height="9" x="3" y="3" rx="1"/>
            <rect width="7" height="5" x="14" y="3" rx="1"/>
            <rect width="7" height="9" x="14" y="12" rx="1"/>
            <rect width="7" height="5" x="3" y="16" rx="1"/>
            @break

        {{-- Cash Register / Caja Diaria --}}
        @case('cash')
        @case('banknote')
        @case('caja')
            <rect width="20" height="12" x="2" y="6" rx="2"/>
            <circle cx="12" cy="12" r="2"/>
            <path d="M6 12h.01M18 12h.01"/>
            @break

        {{-- POS / Shopping Cart --}}
        @case('pos')
        @case('cart')
        @case('shopping-cart')
            <circle cx="8" cy="21" r="1"/>
            <circle cx="19" cy="21" r="1"/>
            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
            @break

        {{-- Sales History / Receipt --}}
        @case('history')
        @case('receipt')
            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/>
            <path d="M14 8H8M16 12H8M13 16H8"/>
            @break

        {{-- Work Orders / Clipboard --}}
        @case('clipboard-list')
        @case('work-orders')
        @case('orders')
            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
            <path d="M12 11h4M12 16h4M8 11h.01M8 16h.01"/>
            @break

        {{-- Plus / Nueva Orden --}}
        @case('plus')
        @case('add')
            <path d="M12 5v14M5 12h14"/>
            @break

        {{-- Quotations / File Text --}}
        @case('quote')
        @case('quotations')
        @case('file-text')
            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
            <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
            <path d="M10 9H8M16 13H8M16 17H8"/>
            @break

        {{-- Inventory / Box --}}
        @case('box')
        @case('inventory')
        @case('package')
            <path d="M16.5 9.4 7.55 4.24a1.78 1.78 0 0 0-2.5 1.55v8.42a1.78 1.78 0 0 0 .89 1.55l8.95 5.16a1.78 1.78 0 0 0 2.5-1.55V10.95a1.78 1.78 0 0 0-.89-1.55Z"/>
            <polyline points="3.29 7 12 12 20.71 7"/>
            <line x1="12" y1="22" x2="12" y2="12"/>
            @break

        {{-- Services / Tools / Wrench --}}
        @case('wrench')
        @case('services')
        @case('tools')
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            @break

        {{-- Clients / Users --}}
        @case('users')
        @case('clients')
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            @break

        {{-- User Single --}}
        @case('user')
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
            @break

        {{-- Suppliers / Truck --}}
        @case('truck')
        @case('suppliers')
        @case('shipping')
            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/>
            <path d="M15 18H9M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14v10Z"/>
            <circle cx="17" cy="18" r="2"/>
            <circle cx="7" cy="18" r="2"/>
            @break

        {{-- Finance / Trending Up / Chart --}}
        @case('finance')
        @case('trending-up')
            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
            <polyline points="16 7 22 7 22 13"/>
            @break

        {{-- Sales Book / Book Open --}}
        @case('book')
        @case('book-open')
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            @break

        {{-- Purchases / Shopping Bag --}}
        @case('purchases')
        @case('shopping-bag')
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
            <path d="M3 6h18M16 10a4 4 0 0 1-8 0"/>
            @break

        {{-- Reports / Bar Chart --}}
        @case('reports')
        @case('bar-chart')
        @case('chart-bar')
            <line x1="12" x2="12" y1="20" y2="10"/>
            <line x1="18" x2="18" y1="20" y2="4"/>
            <line x1="6" x2="6" y1="20" y2="16"/>
            @break

        {{-- Settings --}}
        @case('settings')
            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
            <circle cx="12" cy="12" r="3"/>
            @break

        {{-- Shield / Roles --}}
        @case('shield')
        @case('security')
            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
            @break

        {{-- Logout --}}
        @case('logout')
        @case('log-out')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" x2="9" y1="12" y2="12"/>
            @break

        {{-- Theme Sun --}}
        @case('sun')
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            @break

        {{-- Theme Moon --}}
        @case('moon')
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
            @break

        {{-- Search --}}
        @case('search')
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
            @break

        {{-- Filter --}}
        @case('filter')
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            @break

        {{-- Close / X --}}
        @case('x')
        @case('close')
            <path d="M18 6 6 18M6 6l12 12"/>
            @break

        {{-- Check --}}
        @case('check')
            <polyline points="20 6 9 17 4 12"/>
            @break

        {{-- Check Circle --}}
        @case('check-circle')
        @case('check-circle-2')
            <circle cx="12" cy="12" r="10"/>
            <path d="m9 12 2 2 4-4"/>
            @break

        {{-- Alert Circle --}}
        @case('alert-circle')
        @case('error')
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" x2="12" y1="8" y2="12"/>
            <line x1="12" x2="12.01" y1="16" y2="16"/>
            @break

        {{-- Alert Triangle --}}
        @case('alert-triangle')
        @case('warning')
            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
            <line x1="12" x2="12" y1="9" y2="13"/>
            <line x1="12" x2="12.01" y1="17" y2="17"/>
            @break

        {{-- Info --}}
        @case('info')
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4M12 8h.01"/>
            @break

        {{-- Clock --}}
        @case('clock')
        @case('time')
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
            @break

        {{-- Phone --}}
        @case('phone')
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            @break

        {{-- Mail --}}
        @case('mail')
            <rect width="20" height="16" x="2" y="4" rx="2"/>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            @break

        {{-- Calendar --}}
        @case('calendar')
            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
            <line x1="16" x2="16" y1="2" y2="6"/>
            <line x1="8" x2="8" y1="2" y2="6"/>
            <line x1="3" x2="21" y1="10" y2="10"/>
            @break

        {{-- Printer --}}
        @case('printer')
        @case('print')
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect width="12" height="8" x="6" y="14"/>
            @break

        {{-- QR Code --}}
        @case('qr-code')
        @case('qr')
            <rect width="5" height="5" x="3" y="3" rx="1"/>
            <rect width="5" height="5" x="16" y="3" rx="1"/>
            <rect width="5" height="5" x="3" y="16" rx="1"/>
            <path d="M21 16h-3a2 2 0 0 0-2 2v3M21 21v.01M12 7v3a2 2 0 0 1-2 2H7M3 12h.01M12 3h.01M12 16v.01M16 12h1M21 12v.01M12 21v-1"/>
            @break

        {{-- Camera --}}
        @case('camera')
            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
            <circle cx="12" cy="13" r="3"/>
            @break

        {{-- Trash --}}
        @case('trash')
        @case('delete')
            <path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
            <line x1="10" x2="10" y1="11" y2="17"/>
            <line x1="14" x2="14" y1="11" y2="17"/>
            @break

        {{-- Edit --}}
        @case('edit')
        @case('pencil')
            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
            <path d="m15 5 4 4"/>
            @break

        {{-- Eye / View --}}
        @case('eye')
        @case('view')
            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
            <circle cx="12" cy="12" r="3"/>
            @break

        {{-- Download --}}
        @case('download')
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
            @break

        {{-- Refresh / Sync --}}
        @case('refresh-cw')
        @case('refresh')
        @case('sync')
            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
            <path d="M21 3v5h-5M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
            <path d="M8 16H3v5"/>
            @break

        {{-- External Link --}}
        @case('external-link')
            <path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            @break

        {{-- Tag --}}
        @case('tag')
            <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/>
            <path d="M7 7h.01"/>
            @break

        {{-- Chevron Right --}}
        @case('chevron-right')
            <path d="m9 18 6-6-6-6"/>
            @break

        {{-- Chevron Left --}}
        @case('chevron-left')
            <path d="m15 18-6-6 6-6"/>
            @break

        {{-- Chevron Down --}}
        @case('chevron-down')
            <path d="m6 9 6 6 6-6"/>
            @break

        {{-- Chevron Up --}}
        @case('chevron-up')
            <path d="m18 15-6-6-6 6"/>
            @break

        {{-- Arrow Left --}}
        @case('arrow-left')
            <path d="m12 19-7-7 7-7M19 12H5"/>
            @break

        {{-- Arrow Right --}}
        @case('arrow-right')
            <path d="M5 12h14M12 5l7 7-7 7"/>
            @break

        {{-- Pin / Key --}}
        @case('key')
        @case('pin')
            <path d="m21 2-2 2m-1.5 1.5L16 7l-1.5-1.5M19 5l-2.5 2.5M9.5 14.5a5.5 5.5 0 1 1-7.07-7.07 5.5 5.5 0 0 1 7.07 7.07Zm0 0L22 22"/>
            @break

        {{-- WhatsApp / Message Circle --}}
        @case('message')
        @case('message-circle')
        @case('whatsapp')
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
            @break

        {{-- More Vertical --}}
        @case('more-vertical')
            <circle cx="12" cy="12" r="1"/>
            <circle cx="12" cy="5" r="1"/>
            <circle cx="12" cy="19" r="1"/>
            @break

        @default
            {{-- Default circle dot fallback --}}
            <circle cx="12" cy="12" r="4"/>
    @endswitch
</svg>
