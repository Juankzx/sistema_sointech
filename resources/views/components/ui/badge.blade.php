@props([
    'variant' => 'default',
    'size' => 'md',
    'dot' => false,
])

@php
    $variants = [
        'default' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
        'brand' => 'bg-orange-50 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400 border-orange-200/80 dark:border-orange-800/60',
        'success' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border-emerald-200/80 dark:border-emerald-800/60',
        'warning' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border-amber-200/80 dark:border-amber-800/60',
        'danger' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 border-rose-200/80 dark:border-rose-800/60',
        'info' => 'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-400 border-sky-200/80 dark:border-sky-800/60',
        'purple' => 'bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400 border-purple-200/80 dark:border-purple-800/60',
    ];

    $dotColors = [
        'default' => 'bg-slate-400',
        'brand' => 'bg-orange-500',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
        'purple' => 'bg-purple-500',
    ];

    $sizes = [
        'sm' => 'text-[11px] px-1.5 py-0.5 gap-1',
        'md' => 'text-xs px-2.5 py-0.5 gap-1.5',
        'lg' => 'text-xs px-3 py-1 gap-1.5 font-semibold',
    ];

    $classes = 'inline-flex items-center font-medium rounded-md border tracking-normal ' 
        . ($variants[$variant] ?? $variants['default']) . ' ' 
        . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] ?? 'bg-current' }} shrink-0"></span>
    @endif
    {{ $slot }}
</span>
