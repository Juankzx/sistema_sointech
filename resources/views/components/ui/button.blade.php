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
        'primary' => 'bg-aurora text-white shadow-md shadow-brand-500/25 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 focus-visible:ring-brand-500/40 border border-white/15',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-100 border border-slate-200/80 dark:border-slate-700 focus-visible:ring-brand-400/30 hover:-translate-y-0.5',
        'outline' => 'bg-white/60 dark:bg-slate-900/60 hover:bg-brand-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:border-brand-400 focus-visible:ring-brand-400/30',
        'ghost' => 'bg-transparent hover:bg-brand-500/10 text-slate-600 dark:text-slate-300 hover:text-brand-700 dark:hover:text-brand-200 border border-transparent',
        'danger' => 'bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-500 hover:to-pink-500 text-white shadow-md shadow-rose-500/25 focus-visible:ring-rose-500/30 border border-rose-500/30 hover:-translate-y-0.5',
        'success' => 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white shadow-md shadow-emerald-500/25 focus-visible:ring-emerald-500/30 border border-emerald-500/30 hover:-translate-y-0.5',
    ];

    $sizes = [
        'xs' => 'text-[11px] px-2.5 py-1 gap-1.5 rounded-lg font-semibold',
        'sm' => 'text-xs px-3 py-1.5 gap-1.5 rounded-xl font-semibold',
        'md' => 'text-xs px-4 py-2 gap-2 rounded-xl font-bold',
        'lg' => 'text-sm px-5 py-2.5 gap-2 rounded-xl font-bold',
    ];

    $classes = 'inline-flex items-center justify-center transition-all duration-200 focus:outline-hidden focus-visible:ring-2 disabled:opacity-50 disabled:pointer-events-none active:scale-[0.97] cursor-pointer '
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
