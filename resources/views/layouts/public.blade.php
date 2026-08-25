<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <script>
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>{{ $title ?? (isset($appSettings) && $appSettings->trade_name ? $appSettings->trade_name : config('app.name', 'SOINTECH') . ' - Servicio Técnico Especializado') }}</title>
        <!-- Favicon & PWA Icons (iPhone / Mobile) -->
        <link rel="icon" type="image/png" href="{{ isset($appSettings) && $appSettings->favicon_path ? Storage::url($appSettings->favicon_path) : asset('images/logo-dark.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ isset($appSettings) && $appSettings->favicon_path ? Storage::url($appSettings->favicon_path) : asset('images/logo-dark.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            body { font-family: 'Inter', sans-serif; }
            .custom-scrollbar::-webkit-scrollbar,
            .theme-scrollbar::-webkit-scrollbar {
                height: 6px;
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track,
            .theme-scrollbar::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.6);
                border-radius: 9999px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb,
            .theme-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(59, 130, 246, 0.5);
                border-radius: 9999px;
                border: 1px solid rgba(30, 41, 59, 0.5);
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover,
            .theme-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(59, 130, 246, 0.85);
            }
            .custom-scrollbar,
            .theme-scrollbar {
                scrollbar-width: thin;
                scrollbar-color: rgba(59, 130, 246, 0.5) rgba(15, 23, 42, 0.6);
            }
        </style>
    </head>
    <body class="bg-gray-950 text-gray-100 antialiased selection:bg-blue-500 selection:text-white">
        {{ $slot }}
        @include('components.global-lightbox')
        @livewireScripts
    </body>
</html>
