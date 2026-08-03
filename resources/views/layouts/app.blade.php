<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!-- Prevent Flash of Theme -->
        <script>
            if (!localStorage.getItem('theme')) {
                localStorage.setItem('theme', 'light');
            }
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($appSettings) && $appSettings->trade_name ? $appSettings->trade_name : config('app.name', 'Sointech - Sistema de Servicio Técnico') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ isset($appSettings) && $appSettings->favicon_path ? Storage::url($appSettings->favicon_path) : asset('favicon.png') }}">

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles

        <style>
            body {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#f8fafc] dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-orange-500 selection:text-white" x-data="{ mobileMenuOpen: false, isDark: localStorage.getItem('theme') === 'dark' }">
        
        <div class="min-h-screen flex flex-col md:flex-row">

            @auth
            <!-- DESKTOP SIDEBAR -->
            <aside class="hidden md:flex md:flex-col md:w-64 bg-white dark:bg-slate-900 border-r border-slate-200/80 dark:border-slate-800 shrink-0 sticky top-0 h-screen z-30 shadow-sm">
                <!-- Sidebar Header -->
                <div class="py-6 px-4 border-b border-slate-100 dark:border-slate-800 shrink-0 flex flex-col items-center justify-center relative bg-slate-50/50 dark:bg-slate-900/50">
                    <div class="flex flex-col items-center gap-3 w-full">
                        <div class="relative group cursor-pointer">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-slate-950 p-2 shadow-xl shadow-orange-500/10 border-2 border-orange-500/30 ring-4 ring-orange-500/10 flex items-center justify-center overflow-hidden transition-all duration-300 group-hover:scale-105 group-hover:border-orange-500/60">
                                @if(isset($appSettings) && $appSettings->logo_path)
                                    <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-full h-full object-contain rounded-2xl" alt="Logo">
                                @else
                                    <img src="/images/logo-dark.png" class="w-full h-full object-contain rounded-2xl" alt="Sointech Logo">
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center w-full px-2">
                            <h1 class="text-base font-extrabold tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-amber-400 to-orange-600 uppercase truncate" title="{{ $appSettings->trade_name ?? 'SOIN TECHNOLOGY' }}">
                                {{ $appSettings->trade_name ?? 'SOIN TECHNOLOGY' }}
                            </h1>
                            <span class="inline-block px-2.5 py-0.5 mt-1 bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20 text-[9px] font-black tracking-widest rounded-full uppercase shadow-xs">
                                TECNOLOGÍA & SERVICIO
                            </span>
                        </div>
                    </div>
                    
                    <!-- Global Theme Toggle Button -->
                    <button 
                        type="button" 
                        @click="
                            isDark = !isDark;
                            if (isDark) {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme', 'dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme', 'light');
                            }
                        " 
                        class="absolute top-3 right-3 p-1.5 rounded-lg text-gray-500 hover:text-white hover:bg-gray-800 transition duration-150 cursor-pointer"
                        title="Cambiar Tema"
                    >
                        <!-- Sun Icon (visible in Dark Mode) -->
                        <svg x-show="isDark" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m2.828 9.9a5 5 0 117.072 0l-7.072 0z" />
                        </svg>
                        <!-- Moon Icon (visible in Light Mode) -->
                        <svg x-show="!isDark" class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>


                <!-- Navigation Links -->
                <nav class="flex-1 px-3 py-2 space-y-5 overflow-y-auto theme-scrollbar">
                    
                    <!-- 1. Principal -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Principal</div>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('dashboard') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                                Panel de Control
                            </a>
                        </div>
                    </div>

                    @if(!auth()->user()->isCliente())
                    <!-- 2. Ventas & Caja -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Ventas & POS</div>
                        <div class="space-y-1">
                            <a href="{{ route('cash-registers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('cash-registers.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Caja Diaria
                            </a>
                            <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('pos.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Punto de Venta
                            </a>
                            <a href="{{ route('sales.history') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('sales.history') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Historial de Ventas
                            </a>
                        </div>
                    </div>

                    <!-- 3. Taller de Reparación -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Taller & Servicio</div>
                        <div class="space-y-1">
                            <a href="{{ route('work-orders.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('work-orders.create') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Nueva Orden
                            </a>
                            <a href="{{ route('work-orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('work-orders.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Órdenes de Trabajo
                            </a>
                            <a href="{{ route('quotations.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('quotations.*') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Cotizaciones Rápidas
                            </a>
                        </div>
                    </div>

                    <!-- 4. Inventario & Catálogo -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Inventario & Clientes</div>
                        <div class="space-y-1">
                            <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('inventory.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Inventario & Stock
                            </a>
                            <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('clients.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Clientes
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('suppliers.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Proveedores
                            </a>
                        </div>
                    </div>

                    <!-- 5. Finanzas & Analítica -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Finanzas & Contabilidad</div>
                        <div class="space-y-1">
                            <a href="{{ route('finance.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('finance.dashboard') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Dashboard Financiero
                            </a>
                            <a href="{{ route('finance.sales-book') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('finance.sales-book') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Libro de Ventas
                            </a>
                            <a href="{{ route('finance.purchases') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('finance.purchases') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Compras & Gastos
                            </a>
                            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('reports.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                Reportes Consolidados
                            </a>
                        </div>
                    </div>

                    <!-- 6. Sistema -->
                    <div>
                        <div class="px-4 pb-2 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sistema</div>
                        <div class="space-y-1">
                            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('settings.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                Configuración
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ Route::is('users.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Usuarios & Roles
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </nav>

                <!-- User Footer -->
                <div class="p-4 border-t border-gray-800 shrink-0">
                    <div class="flex items-center justify-between bg-gray-900/60 p-2 rounded-2xl border border-gray-800/80">
                        <div class="flex items-center gap-3 overflow-hidden px-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white text-xs font-bold uppercase shadow-sm flex-shrink-0">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col overflow-hidden">
                                <span class="text-xs font-bold text-white truncate leading-tight">{{ auth()->user()->name }}</span>
                                <span class="text-[9px] text-emerald-400 font-black uppercase tracking-widest mt-0.5">{{ auth()->user()->role }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('logout') }}" class="p-2.5 rounded-xl text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200 shrink-0" title="Cerrar Sesión">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                    </div>
                </div>
            </aside>
            @endauth

            <!-- MOBILE NAV & HEADER -->
            <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden pb-16 md:pb-0">
                
                <!-- Mobile Navbar Top -->
                <header class="bg-gray-850 border-b border-gray-800 shadow-sm sticky top-0 z-40 md:hidden">
                    <div class="px-4 h-16 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-950 p-1 shadow-md border border-orange-500/30 flex items-center justify-center overflow-hidden shrink-0">
                                @if(isset($appSettings) && $appSettings->logo_path)
                                    <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-full h-full object-contain rounded-xl" alt="Logo">
                                @else
                                    <img src="/images/logo-dark.png" class="w-full h-full object-contain rounded-xl" alt="Sointech Logo">
                                @endif
                            </div>
                            <div>
                                <span class="text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-amber-400 to-orange-600 tracking-wider uppercase block truncate max-w-[130px]">
                                    {{ $appSettings->trade_name ?? 'SOIN TECHNOLOGY' }}
                                </span>
                                <span class="text-[8px] font-black text-orange-500 uppercase tracking-widest block">SOIN TECH</span>
                            </div>
                        </div>
                        
                        @auth
                        <div class="flex items-center gap-2">
                            <!-- Mobile Theme Toggle Button -->
                            <button 
                                type="button" 
                                @click="
                                    isDark = !isDark;
                                    if (isDark) {
                                        document.documentElement.classList.add('dark');
                                        localStorage.setItem('theme', 'dark');
                                    } else {
                                        document.documentElement.classList.remove('dark');
                                        localStorage.setItem('theme', 'light');
                                    }
                                " 
                                class="p-2 rounded-xl text-gray-400 hover:text-white hover:bg-gray-800 transition duration-150 cursor-pointer"
                                title="Cambiar Tema"
                            >
                                <!-- Sun Icon (visible in Dark Mode) -->
                                <svg x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m2.828 9.9a5 5 0 117.072 0l-7.072 0z" />
                                </svg>
                                <!-- Moon Icon (visible in Light Mode) -->
                                <svg x-show="!isDark" class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                            
                            <button @click="mobileMenuOpen = true" class="p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </div>
                        @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-300 hover:text-white px-2 py-1.5 rounded-lg">Ingresar</a>
                            <a href="{{ route('register') }}" class="text-xs font-semibold bg-blue-600 text-white hover:bg-blue-500 px-2.5 py-1.5 rounded-lg">Registrarse</a>
                        </div>
                        @endauth
                    </div>
                </header>

                @auth
                <!-- MOBILE SIDEBAR / DRAWER (OFF-CANVAS) -->
                <div x-show="mobileMenuOpen" 
                     class="fixed inset-0 z-50 md:hidden" 
                     x-description="Mobile menu drawer"
                     x-ref="dialog" 
                     aria-modal="true" 
                     style="display: none;">
                    
                    <!-- Overlay background -->
                    <div x-show="mobileMenuOpen" 
                         x-transition:enter="transition-opacity ease-linear duration-300" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         x-transition:leave="transition-opacity ease-linear duration-300" 
                         x-transition:leave-start="opacity-100" 
                         x-transition:leave-end="opacity-0" 
                         @click="mobileMenuOpen = false" 
                         class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm" 
                         aria-hidden="true"></div>

                    <!-- Drawer panel -->
                    <div x-show="mobileMenuOpen" 
                         x-transition:enter="transition ease-in-out duration-300 transform" 
                         x-transition:enter-start="-translate-x-full" 
                         x-transition:enter-end="translate-x-0" 
                         x-transition:leave="transition ease-in-out duration-300 transform" 
                         x-transition:leave-start="translate-x-0" 
                         x-transition:leave-end="-translate-x-full" 
                         class="fixed inset-y-0 left-0 w-full max-w-xs bg-gray-950 border-r border-gray-800 flex flex-col p-6 shadow-2xl">
                        
                        <!-- Drawer Header -->
                        <div class="flex flex-col items-center justify-center pb-6 border-b border-gray-800 relative">
                            <button @click="mobileMenuOpen = false" class="absolute top-0 right-0 p-1.5 rounded-lg text-gray-500 hover:text-white hover:bg-gray-800 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="flex flex-col items-center gap-3 mt-4">
                                @if(isset($appSettings) && $appSettings->logo_path)
                                    <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-20 h-20 object-cover rounded-full shadow-xl border-2 border-gray-700/50 transition-all hover:scale-105" alt="Logo">
                                @else
                                    <img :src="isDark ? '/images/logo-dark.png' : '/images/logo-light.png'" class="h-10 w-auto object-contain" alt="Sointech Logo">
                                @endif
                                
                                @if(isset($appSettings) && $appSettings->trade_name)
                                    <h1 class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400 tracking-wider text-center uppercase">
                                        {{ $appSettings->trade_name }}
                                    </h1>
                                @endif
                            </div>
                        </div>


                        <!-- Drawer Links -->
                        <nav class="flex-1 space-y-4 py-2 overflow-y-auto theme-scrollbar">
                            
                            <!-- Principal -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest">Principal</div>
                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('dashboard') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                                        Panel de Control
                                    </a>
                                </div>
                            </div>

                            @if(!auth()->user()->isCliente())
                            <!-- Ventas / POS -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest mt-2">Ventas / POS</div>
                                <div class="space-y-1">
                                    <!-- Caja Link -->
                                    <a href="{{ route('cash-registers.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('cash-registers.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Caja Diaria
                                    </a>
                                    <!-- POS Link -->
                                    <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.index') ? 'bg-orange-500/10 text-orange-400 font-black' : 'text-gray-400 hover:text-white hover:bg-gray-800' }} group flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-200">
                                        <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('pos.index') ? 'text-orange-400' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Punto de Venta (POS)
                                    </a>
                                    <!-- Historial Ventas Link -->
                                    <a href="{{ route('sales.history') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('sales.history') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Historial de Ventas
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if(!auth()->user()->isCliente())
                            <!-- Taller -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest">Taller</div>
                                <div class="space-y-1">
                                    <a href="{{ route('work-orders.create') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('work-orders.create') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Nueva Orden
                                    </a>
                                    <a href="{{ route('work-orders.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('work-orders.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        Órdenes de Trabajo
                                    </a>
                                    <a href="{{ route('quotations.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('quotations.*') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Cotizaciones
                                    </a>
                                </div>
                            </div>

                            <!-- Gestión -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest">Gestión</div>
                                <div class="space-y-1">
                                    <a href="{{ route('clients.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('clients.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Clientes
                                    </a>
                                    <a href="{{ route('inventory.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('inventory.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        Inventario
                                    </a>
                                </div>
                            </div>

                            <!-- Análisis -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest mt-2">Análisis</div>
                                <div class="space-y-1">
                                    <a href="{{ route('reports.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('reports.index') ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-md shadow-purple-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Reportes Consolidados
                                    </a>
                                </div>
                            </div>

                            <!-- Sistema -->
                            <div>
                                <div class="px-4 pb-2 text-[10px] font-black text-gray-500 uppercase tracking-widest">Sistema</div>
                                <div class="space-y-1">
                                    <a href="{{ route('settings.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('settings.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Configuración
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('users.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ Route::is('users.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-900' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        Usuarios
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </nav>

                        <!-- Drawer Footer -->
                        <div class="mt-auto pt-6 border-t border-gray-800">
                            <div class="flex items-center justify-between bg-gray-900/60 p-2 rounded-2xl border border-gray-800/80">
                                <div class="flex items-center gap-3 overflow-hidden px-2">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white text-xs font-bold uppercase shadow-sm flex-shrink-0">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                    <div class="flex flex-col overflow-hidden">
                                        <span class="text-xs font-bold text-white truncate leading-tight">{{ auth()->user()->name }}</span>
                                        <span class="text-[9px] text-emerald-400 font-black uppercase tracking-widest mt-0.5">{{ auth()->user()->role }}</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('logout') }}" class="p-2.5 rounded-xl text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200 shrink-0" title="Cerrar Sesión">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- MAIN WORKSPACE -->
                <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
                    @if (session()->has('message'))
                        <div class="mb-6 bg-green-950/50 border border-green-500/30 text-green-300 px-5 py-4 rounded-2xl relative shadow-lg shadow-green-500/5 flex items-center gap-3 animate-fade-in" role="alert">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-ping"></span>
                            <span class="text-sm font-medium">{{ session('message') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>

                <!-- MOBILE BOTTOM NAVIGATION -->
                @auth
                @if(!auth()->user()->isCliente())
                <nav class="fixed bottom-0 w-full bg-gray-950 border-t border-gray-800 z-40 md:hidden">
                    <div class="flex justify-around items-center h-16">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full {{ Route::is('dashboard') ? 'text-orange-500' : 'text-gray-400 hover:text-gray-300' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                            <span class="text-[9px] mt-1 font-semibold">Inicio</span>
                        </a>
                        <!-- Nueva OT -->
                        <a href="{{ route('work-orders.create') }}" class="flex flex-col items-center justify-center w-full {{ Route::is('work-orders.create') ? 'text-orange-500' : 'text-gray-400 hover:text-gray-300' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[9px] mt-1 font-semibold">Nueva OT</span>
                        </a>
                        <!-- Órdenes -->
                        <a href="{{ route('work-orders.index') }}" class="flex flex-col items-center justify-center w-full {{ Route::is('work-orders.index') ? 'text-orange-500' : 'text-gray-400 hover:text-gray-300' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span class="text-[9px] mt-1 font-semibold">Órdenes</span>
                        </a>
                        <!-- Inventario -->
                        <a href="{{ route('inventory.index') }}" class="flex flex-col items-center justify-center w-full {{ Route::is('inventory.index') ? 'text-orange-500' : 'text-gray-400 hover:text-gray-300' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="text-[9px] mt-1 font-semibold">Inventario</span>
                        </a>
                    </div>
                </nav>
                @endif
                @endauth

            </div>
        </div>

        <!-- Motor de Impresión Global (A4 y Térmica POS) -->
        <script>
            window.printContent = function(elementId, qrCanvasId = 'qr-canvas') {
                const el = document.getElementById(elementId);
                if (!el) { 
                    console.error('Elemento no encontrado para imprimir:', elementId); 
                    alert('Error: No se encontró la plantilla de impresión (' + elementId + ').');
                    return; 
                }
                const printContent = el.innerHTML;
                const isThermal = elementId.toLowerCase().includes('thermal') || elementId.toLowerCase().includes('pos') || elementId.toLowerCase().includes('ticket');

                // Remove existing print iframes if any
                document.querySelectorAll('.sointech-print-iframe').forEach(i => i.remove());

                const iframe = document.createElement('iframe');
                iframe.className = 'sointech-print-iframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = '0';
                document.body.appendChild(iframe);

                const doc = iframe.contentWindow.document;
                doc.open();
                doc.write('<!DOCTYPE html><html><head><title>Imprimir Comprobante Sointech</title>');
                doc.write('<script src="https://cdn.tailwindcss.com"><\/script>');
                doc.write('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">');
                doc.write('<style>');
                if (isThermal) {
                    doc.write('  @page { size: 80mm auto; margin: 0mm; }');
                    doc.write('  html, body { width: 80mm; max-width: 80mm; margin: 0 auto; padding: 2mm; background: #fff; color: #000; font-family: "Inter", "Segoe UI", sans-serif; font-size: 11px; line-height: 1.2; -webkit-print-color-adjust: exact; print-color-adjust: exact; }');
                    doc.write('  .thermal-ticket-container { width: 100% !important; max-width: 76mm !important; margin: 0 auto !important; padding: 0 !important; }');
                } else {
                    doc.write('  @page { size: A4 portrait; margin: 8mm; }');
                    doc.write('  body { font-family: "Inter", sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; background: #fff; color: #000; }');
                }
                doc.write('</style>');
                doc.write('</head><body class="bg-white text-black p-0">');
                doc.write(printContent);
                doc.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"><\/script>');
                doc.write('<script>');
                doc.write('  function triggerPrint() {');
                doc.write('    const qrCanvas = document.getElementById("' + qrCanvasId + '");');
                doc.write('    if (qrCanvas && qrCanvas.dataset.url && typeof QRious !== "undefined") {');
                doc.write('      try { new QRious({ element: qrCanvas, value: qrCanvas.dataset.url, size: ' + (isThermal ? 110 : 150) + ' }); } catch(e) {}');
                doc.write('    }');
                doc.write('    setTimeout(function() { window.focus(); window.print(); }, 400);');
                doc.write('  }');
                doc.write('  if (document.readyState === "complete") { triggerPrint(); } else { window.onload = triggerPrint; }');
                doc.write('<\/script>');
                doc.write('</body></html>');
                doc.close();
            };

            // Utilidad global para formatear RUT
            window.formatRut = function(rut) {
                if (!rut) return '';
                let actual = rut.replace(/[^0-9kK]/g, '').toUpperCase();
                actual = actual.slice(0, 9);
                if (actual.length <= 1) return actual;
                let cuerpo = actual.slice(0, -1);
                let dv = actual.slice(-1);
                cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return cuerpo + '-' + dv;
            };

            // Utilidad global para validar RUT (Algoritmo Módulo 11 Chile)
            window.validateRut = function(rut) {
                if (!rut) return false;
                let clean = rut.replace(/[^0-9kK]/g, '').toUpperCase();
                if (clean.length < 8 || clean.length > 9) return false;
                let body = clean.slice(0, -1);
                let dv = clean.slice(-1);
                let sum = 0;
                let multiplier = 2;
                for (let i = body.length - 1; i >= 0; i--) {
                    sum += parseInt(body.charAt(i), 10) * multiplier;
                    multiplier = multiplier === 7 ? 2 : multiplier + 1;
                }
                let expected = 11 - (sum % 11);
                let expectedStr = expected === 11 ? '0' : (expected === 10 ? 'K' : expected.toString());
                return dv === expectedStr;
            };
        </script>

        @livewireScripts
    </body>
</html>
