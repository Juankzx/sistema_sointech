@props([
    'padding' => true,
    'hover' => false,
])

@php
    $baseClass = 'bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-xl shadow-xs transition-colors duration-150';
    if ($hover) {
        $baseClass .= ' hover:border-slate-300 dark:hover:border-slate-700';
    }
    if ($padding) {
        $baseClass .= ' p-4 sm:p-5';
    }
@endphp

<div {{ $attributes->merge(['class' => $baseClass]) }}>
    {{ $slot }}
</div>
