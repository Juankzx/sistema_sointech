<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <script>
            try {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.style.colorScheme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    document.documentElement.style.colorScheme = 'dark';
                    if (!localStorage.getItem('theme')) {
                        localStorage.setItem('theme', 'dark');
                    }
                }
            } catch(e) {
                document.documentElement.classList.add('dark');
            }
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
        <title>{{ $title ?? (isset($appSettings) && $appSettings->trade_name ? $appSettings->trade_name : config('app.name', 'SOINTECH') . ' - Servicio Técnico') }}</title>
        <!-- Favicon & PWA Icons (Apple Minimalist Suite) -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#f8fafc" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#090d16" media="(prefers-color-scheme: dark)">
        @if(isset($appSettings) && $appSettings->favicon_path)
            <link rel="icon" type="image/png" href="{{ Storage::url($appSettings->favicon_path) }}">
            <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($appSettings->favicon_path) }}">
        @else
            <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
            <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
            <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        @endif
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                padding-top: env(safe-area-inset-top, 0px);
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }
        </style>
    </head>
    <body class="bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 antialiased selection:bg-brand-500 selection:text-white transition-colors duration-150">
        {{ $slot }}
        @include('components.global-lightbox')
        @livewireScripts
    </body>
</html>
