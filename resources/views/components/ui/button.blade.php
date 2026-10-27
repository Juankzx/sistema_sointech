@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'icon' => null,
    'iconRight' => null,
    'disabled' => false,
])

@php
    $variants = [
        'primary' => 'bg-orange-600 hover:bg-orange-700 text-white shadow-xs focus-visible:ring-orange-500/30 border border-orange-700/40',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 focus-visible:ring-slate-400/30',
        'outline' => 'bg-transparent hover:bg-slate-100 text-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700 focus-visible:ring-slate-400/30',
        'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 dark:hover:bg-slate-800/60 border border-transparent',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-xs focus-visible:ring-rose-500/30 border border-rose-700/40',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs focus-visible:ring-emerald-500/30 border border-emerald-700/40',
    ];

    $sizes = [
        'xs' => 'text-[11px] px-2 py-1 gap-1.5 rounded-md font-medium',
        'sm' => 'text-xs px-2.5 py-1.5 gap-1.5 rounded-lg font-medium',
        'md' => 'text-xs px-3.5 py-2 gap-2 rounded-lg font-semibold',
        'lg' => 'text-sm px-4 py-2.5 gap-2 rounded-lg font-semibold',
    ];

    $classes = 'inline-flex items-center justify-center transition-all duration-150 focus:outline-hidden focus-visible:ring-2 disabled:opacity-50 disabled:pointer-events-none active:scale-[0.98] '
        . ($variants[$variant] ?? $variants['primary']) . ' '
        . ($sizes[$size] ?? $sizes['md']);
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <x-ui.icon :name="$icon" class="w-4 h-4 shrink-0" />
    @endif
    
    {{ $slot }}

    @if($iconRight)
        <x-ui.icon :name="$iconRight" class="w-4 h-4 shrink-0" />
    @endif
</button>
