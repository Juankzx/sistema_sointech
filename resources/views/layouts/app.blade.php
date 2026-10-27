<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <!-- Theme Initialization Script -->
        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($appSettings) && $appSettings->trade_name ? $appSettings->trade_name : config('app.name', 'Sointech - Sistema de Servicio Técnico') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Favicon & PWA Icons (iPhone / Mobile) -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#090d16" media="(prefers-color-scheme: dark)">
        <link rel="icon" type="image/png" href="{{ isset($appSettings) && $appSettings->favicon_path ? Storage::url($appSettings->favicon_path) : asset('images/logo-dark.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ isset($appSettings) && $appSettings->favicon_path ? Storage::url($appSettings->favicon_path) : asset('images/logo-dark.png') }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="{{ isset($appSettings) && $appSettings->trade_name ? $appSettings->trade_name : 'Sointech' }}">

        <!-- SweetAlert2 & Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles

        <style>
            body {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                padding-top: env(safe-area-inset-top, 0px);
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }
        </style>
    </head>
    <body 
        class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-orange-500 selection:text-white min-h-screen" 
        x-data="{
            mobileMenuOpen: false,
            isDark: document.documentElement.classList.contains('dark'),
            toggleTheme() {
                this.isDark = !this.isDark;
                if (this.isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            }
        }"
    >
        <div class="min-h-screen flex flex-col md:flex-row">

            @auth
            <!-- DESKTOP SIDEBAR -->
            <aside class="hidden md:flex md:flex-col md:w-64 bg-white dark:bg-slate-900 border-r border-slate-200/90 dark:border-slate-800 shrink-0 sticky top-0 h-screen z-30">
                <!-- Sidebar Brand Header -->
                <div class="h-16 px-5 border-b border-slate-200/90 dark:border-slate-800 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-lg bg-slate-900 dark:bg-slate-950 p-1.5 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                            @if(isset($appSettings) && $appSettings->logo_path)
                                <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-full h-full object-contain" alt="Logo">
                            @else
                                <img src="{{ asset('images/logo-dark.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-sm font-semibold text-slate-900 dark:text-white truncate leading-tight" title="{{ $appSettings->trade_name ?? 'SOINTECH' }}">
                                {{ $appSettings->trade_name ?? 'SOINTECH' }}
                            </h1>
                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 truncate leading-tight">
                                Servicio Técnico
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-3 py-3 space-y-4 overflow-y-auto theme-scrollbar">
                    
                    <!-- 1. Principal -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Principal</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('dashboard') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="dashboard" class="w-4 h-4 {{ Route::is('dashboard') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Panel de Control</span>
                            </a>
                        </div>
                    </div>

                    @if(!auth()->user()->isCliente())
                    <!-- 2. Ventas & Caja -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Ventas & POS</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('cash-registers.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('cash-registers.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="caja" class="w-4 h-4 {{ Route::is('cash-registers.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Caja Diaria</span>
                            </a>
                            <a href="{{ route('pos.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('pos.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="pos" class="w-4 h-4 {{ Route::is('pos.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Punto de Venta</span>
                            </a>
                            <a href="{{ route('sales.history') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('sales.history') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="history" class="w-4 h-4 {{ Route::is('sales.history') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Historial de Ventas</span>
                            </a>
                        </div>
                    </div>

                    <!-- 3. Taller de Reparación -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Taller & Servicio</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('work-orders.create') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('work-orders.create') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="plus" class="w-4 h-4 {{ Route::is('work-orders.create') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Nueva Orden</span>
                            </a>
                            <a href="{{ route('work-orders.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('work-orders.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="work-orders" class="w-4 h-4 {{ Route::is('work-orders.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Órdenes de Trabajo</span>
                            </a>
                            <a href="{{ route('quotations.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('quotations.*') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="quote" class="w-4 h-4 {{ Route::is('quotations.*') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Cotizaciones Rápidas</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Inventario & Catálogo -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Inventario & Clientes</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('inventory.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('inventory.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="box" class="w-4 h-4 {{ Route::is('inventory.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Inventario & Stock</span>
                            </a>
                            <a href="{{ route('services.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('services.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="tools" class="w-4 h-4 {{ Route::is('services.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Catálogo de Servicios</span>
                            </a>
                            <a href="{{ route('clients.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('clients.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="clients" class="w-4 h-4 {{ Route::is('clients.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Clientes</span>
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('suppliers.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="truck" class="w-4 h-4 {{ Route::is('suppliers.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Proveedores</span>
                            </a>
                        </div>
                    </div>

                    <!-- 5. Finanzas & Analítica -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Finanzas & Contabilidad</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('finance.dashboard') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('finance.dashboard') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="finance" class="w-4 h-4 {{ Route::is('finance.dashboard') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Dashboard Financiero</span>
                            </a>
                            <a href="{{ route('finance.sales-book') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('finance.sales-book') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="book" class="w-4 h-4 {{ Route::is('finance.sales-book') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Libro de Ventas</span>
                            </a>
                            <a href="{{ route('finance.purchases') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('finance.purchases') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="purchases" class="w-4 h-4 {{ Route::is('finance.purchases') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Compras & Gastos</span>
                            </a>
                            <a href="{{ route('reports.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('reports.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="reports" class="w-4 h-4 {{ Route::is('reports.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Reportes Consolidados</span>
                            </a>
                        </div>
                    </div>

                    <!-- 6. Sistema -->
                    <div>
                        <div class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Sistema</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('settings.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('settings.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="settings" class="w-4 h-4 {{ Route::is('settings.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Configuración</span>
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="group flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors duration-150 {{ Route::is('users.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100/70 dark:hover:bg-slate-800/60' }}">
                                <x-ui.icon name="shield" class="w-4 h-4 {{ Route::is('users.index') ? 'text-orange-600 dark:text-orange-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" />
                                <span>Usuarios & Roles</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </nav>

                <!-- Sidebar User Footer -->
                <div class="p-3 border-t border-slate-200/90 dark:border-slate-800 shrink-0">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-slate-100/70 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-800">
                        <div class="flex items-center gap-2.5 min-w-0 pr-1">
                            <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate leading-tight">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium truncate capitalize">
                                    {{ auth()->user()->role }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-0.5 shrink-0">
                            <!-- Theme Toggle -->
                            <button 
                                type="button" 
                                @click="toggleTheme()" 
                                class="p-1.5 rounded-md text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700/60 transition-colors" 
                                :title="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
                            >
                                <x-ui.icon x-show="!isDark" name="moon" class="w-3.5 h-3.5" />
                                <x-ui.icon x-show="isDark" name="sun" class="w-3.5 h-3.5" style="display: none;" />
                            </button>

                            <!-- Logout -->
                            <a 
                                href="{{ route('logout') }}" 
                                class="p-1.5 rounded-md text-slate-500 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" 
                                title="Cerrar Sesión"
                            >
                                <x-ui.icon name="logout" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
            @endauth

            <!-- MOBILE NAV & HEADER -->
            <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden pb-16 md:pb-0 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100">
                
                <!-- Mobile Navbar Top -->
                <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 md:hidden">
                    <div class="px-4 h-14 flex items-center justify-between">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 dark:bg-slate-950 p-1 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                @if(isset($appSettings) && $appSettings->logo_path)
                                    <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-full h-full object-contain" alt="Logo">
                                @else
                                    <img src="{{ asset('images/logo-dark.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="text-xs font-semibold text-slate-900 dark:text-white truncate block">
                                    {{ $appSettings->trade_name ?? 'SOINTECH' }}
                                </span>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block">Servicio Técnico</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5">
                            <!-- Mobile Theme Toggle -->
                            <button 
                                type="button" 
                                @click="toggleTheme()" 
                                class="p-2 rounded-lg text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                :title="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
                            >
                                <x-ui.icon x-show="!isDark" name="moon" class="w-4 h-4" />
                                <x-ui.icon x-show="isDark" name="sun" class="w-4 h-4" style="display: none;" />
                            </button>

                            @auth
                            <button 
                                @click="mobileMenuOpen = true" 
                                class="p-2 rounded-lg text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-hidden"
                                aria-label="Abrir menú"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            @else
                            <div class="flex items-center gap-2">
                                <a href="{{ route('login') }}" class="text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white px-2 py-1">Ingresar</a>
                                <a href="{{ route('register') }}" class="text-xs font-medium bg-orange-600 text-white hover:bg-orange-700 px-3 py-1.5 rounded-lg">Registrarse</a>
                            </div>
                            @endauth
                        </div>
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
                         x-transition:enter="transition-opacity ease-linear duration-200" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         x-transition:leave="transition-opacity ease-linear duration-200" 
                         x-transition:leave-start="opacity-100" 
                         x-transition:leave-end="opacity-0" 
                         @click="mobileMenuOpen = false" 
                         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" 
                         aria-hidden="true"></div>

                    <!-- Drawer panel -->
                    <div x-show="mobileMenuOpen" 
                         x-transition:enter="transition ease-in-out duration-250 transform" 
                         x-transition:enter-start="-translate-x-full" 
                         x-transition:enter-end="translate-x-0" 
                         x-transition:leave="transition ease-in-out duration-250 transform" 
                         x-transition:leave-start="translate-x-0" 
                         x-transition:leave-end="-translate-x-full" 
                         class="fixed inset-y-0 left-0 w-full max-w-xs bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col p-4 shadow-xl">
                        
                        <!-- Drawer Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-slate-900 dark:bg-slate-950 p-1 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                    @if(isset($appSettings) && $appSettings->logo_path)
                                        <img src="{{ Storage::url($appSettings->logo_path) }}" class="w-full h-full object-contain" alt="Logo">
                                    @else
                                        <img src="{{ asset('images/logo-dark.png') }}" class="w-full h-full object-contain" alt="Sointech Logo">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                        {{ $appSettings->trade_name ?? 'SOINTECH' }}
                                    </h2>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Servicio Técnico</p>
                                </div>
                            </div>

                            <button @click="mobileMenuOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-hidden">
                                <x-ui.icon name="x" class="w-5 h-5" />
                            </button>
                        </div>

                        <!-- Drawer Links -->
                        <nav class="flex-1 space-y-4 py-3 overflow-y-auto theme-scrollbar">
                            
                            <!-- Principal -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Principal</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('dashboard') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="dashboard" class="w-4 h-4" />
                                        <span>Panel de Control</span>
                                    </a>
                                </div>
                            </div>

                            @if(!auth()->user()->isCliente())
                            <!-- Ventas / POS -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Ventas & POS</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('cash-registers.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('cash-registers.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="caja" class="w-4 h-4" />
                                        <span>Caja Diaria</span>
                                    </a>
                                    <a href="{{ route('pos.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('pos.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="pos" class="w-4 h-4" />
                                        <span>Punto de Venta</span>
                                    </a>
                                    <a href="{{ route('sales.history') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('sales.history') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="history" class="w-4 h-4" />
                                        <span>Historial de Ventas</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Taller -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Taller & Servicio</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('work-orders.create') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('work-orders.create') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="plus" class="w-4 h-4" />
                                        <span>Nueva Orden</span>
                                    </a>
                                    <a href="{{ route('work-orders.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('work-orders.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="work-orders" class="w-4 h-4" />
                                        <span>Órdenes de Trabajo</span>
                                    </a>
                                    <a href="{{ route('quotations.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('quotations.*') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="quote" class="w-4 h-4" />
                                        <span>Cotizaciones Rápidas</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Gestión -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Inventario & Clientes</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('inventory.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('inventory.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="box" class="w-4 h-4" />
                                        <span>Inventario & Stock</span>
                                    </a>
                                    <a href="{{ route('services.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('services.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="tools" class="w-4 h-4" />
                                        <span>Catálogo de Servicios</span>
                                    </a>
                                    <a href="{{ route('clients.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('clients.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="clients" class="w-4 h-4" />
                                        <span>Clientes</span>
                                    </a>
                                    <a href="{{ route('suppliers.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('suppliers.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="truck" class="w-4 h-4" />
                                        <span>Proveedores</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Finanzas -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Finanzas & Contabilidad</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('finance.dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('finance.dashboard') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="finance" class="w-4 h-4" />
                                        <span>Dashboard Financiero</span>
                                    </a>
                                    <a href="{{ route('finance.sales-book') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('finance.sales-book') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="book" class="w-4 h-4" />
                                        <span>Libro de Ventas</span>
                                    </a>
                                    <a href="{{ route('finance.purchases') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('finance.purchases') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="purchases" class="w-4 h-4" />
                                        <span>Compras & Gastos</span>
                                    </a>
                                    <a href="{{ route('reports.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('reports.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="reports" class="w-4 h-4" />
                                        <span>Reportes Consolidados</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Sistema -->
                            <div>
                                <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Sistema</div>
                                <div class="space-y-0.5">
                                    <a href="{{ route('settings.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('settings.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="settings" class="w-4 h-4" />
                                        <span>Configuración</span>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <a href="{{ route('users.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ Route::is('users.index') ? 'bg-orange-50 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                        <x-ui.icon name="shield" class="w-4 h-4" />
                                        <span>Usuarios & Roles</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </nav>

                        <!-- Drawer Footer -->
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-800 shrink-0">
                            <div class="flex items-center justify-between p-2 rounded-lg bg-slate-100/70 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-800">
                                <div class="flex items-center gap-2.5 min-w-0 pr-1">
                                    <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate leading-tight">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium truncate capitalize">
                                            {{ auth()->user()->role }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1 shrink-0">
                                    <a 
                                        href="{{ route('logout') }}" 
                                        class="p-1.5 rounded-md text-slate-500 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" 
                                        title="Cerrar Sesión"
                                    >
                                        <x-ui.icon name="logout" class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- MAIN WORKSPACE -->
                <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8 max-w-7xl w-full mx-auto">
                    @if (session()->has('message'))
                        <div class="mb-5 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl flex items-center gap-2.5" role="alert">
                            <x-ui.icon name="check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                            <span class="text-xs font-medium">{{ session('message') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>

                <!-- MOBILE BOTTOM NAVIGATION (PWA GLOBAL NAV) -->
                @auth
                @if(!auth()->user()->isCliente())
                <style>
                    body.modal-open .pwa-bottom-nav {
                        display: none !important;
                    }
                </style>
                <nav class="fixed bottom-0 left-0 right-0 w-full bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 z-40 md:hidden pwa-bottom-nav safe-area-bottom shadow-lg">
                    <div class="grid grid-cols-4 max-w-lg mx-auto items-center py-1 px-1">
                        <!-- 1. Inicio (Dashboard) -->
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center py-1.5 transition-colors {{ Route::is('dashboard') ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium' }}">
                            <x-ui.icon name="dashboard" class="w-4 h-4 shrink-0" />
                            <span class="text-[10px] mt-0.5 tracking-tight">Inicio</span>
                        </a>
                        <!-- 2. Nueva OT -->
                        <a href="{{ route('work-orders.index', ['create' => 1]) }}" class="flex flex-col items-center justify-center py-1.5 transition-colors {{ Route::is('work-orders.index') && request()->get('create') ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium' }}">
                            <x-ui.icon name="plus" class="w-4 h-4 shrink-0" />
                            <span class="text-[10px] mt-0.5 tracking-tight">Nueva OT</span>
                        </a>
                        <!-- 3. Órdenes -->
                        <a href="{{ route('work-orders.index') }}" class="flex flex-col items-center justify-center py-1.5 transition-colors {{ Route::is('work-orders.index') && !request()->get('create') ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium' }}">
                            <x-ui.icon name="work-orders" class="w-4 h-4 shrink-0" />
                            <span class="text-[10px] mt-0.5 tracking-tight">Órdenes</span>
                        </a>
                        <!-- 4. Inventario -->
                        <a href="{{ route('inventory.index') }}" class="flex flex-col items-center justify-center py-1.5 transition-colors {{ Route::is('inventory.index') ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium' }}">
                            <x-ui.icon name="box" class="w-4 h-4 shrink-0" />
                            <span class="text-[10px] mt-0.5 tracking-tight">Inventario</span>
                        </a>
                    </div>
                </nav>
                @endif
                @endauth

            </div>
        </div>

        <!-- Motor de Impresión Global (A4 y Térmica POS) -->
        <script>
            window.printThermalTicket = function(orderId) {
                window.open('/ot/' + orderId + '/print-sticker', '_blank', 'width=380,height=320');
            };

            window.printStickerLabel = function(orderId) {
                window.open('/ot/' + orderId + '/print-sticker', '_blank', 'width=380,height=320');
            };

            window.printContent = function(elementId, qrCanvasId = 'qr-canvas') {
                let el = document.getElementById(elementId);
                if (!el && elementId.includes('thermal')) {
                    el = document.querySelector('.thermal-ticket-container') || document.querySelector('[id*="thermal"]');
                }
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

            window.compressAndUploadPhoto = function(event, wireProperty, wireComponent) {
                const input = event.target;
                if (!input.files || !input.files[0]) return;
                const file = input.files[0];

                const uploadFile = (fileToUpload) => {
                    if (!wireComponent) return;
                    wireComponent.upload(wireProperty, fileToUpload,
                        () => { input.value = ''; },
                        (error) => { console.error('Upload error:', error); }
                    );
                };

                if (file.type.startsWith('image/') || file.name.match(/\.(heic|heif|jpg|jpeg|png|webp)$/i)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            const maxDim = 1600;
                            let w = img.width, h = img.height;
                            if (w > maxDim || h > maxDim) {
                                if (w > h) { h = Math.round((h * maxDim) / w); w = maxDim; }
                                else { w = Math.round((w * maxDim) / h); h = maxDim; }
                            }
                            const canvas = document.createElement('canvas');
                            canvas.width = w; canvas.height = h;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, w, h);
                            canvas.toBlob(function(blob) {
                                if (!blob) { uploadFile(file); return; }
                                const newName = (file.name || 'foto').replace(/\.[^/.]+$/, '') + '.jpg';
                                const compressedFile = new File([blob], newName, { type: 'image/jpeg' });
                                uploadFile(compressedFile);
                            }, 'image/jpeg', 0.82);
                        };
                        img.onerror = function() { uploadFile(file); };
                        img.src = e.target.result;
                    };
                    reader.onerror = function() { uploadFile(file); };
                    reader.readAsDataURL(file);
                } else {
                    uploadFile(file);
                }
            };

            window.compressAndUploadMultiplePhotos = function(event, wireProperty, wireComponent) {
                const input = event.target;
                if (!input.files || input.files.length === 0) return;

                const files = Array.from(input.files);
                const compressedFiles = [];
                let processed = 0;

                const uploadAll = () => {
                    if (!wireComponent) return;
                    wireComponent.uploadMultiple(wireProperty, compressedFiles,
                        () => { input.value = ''; },
                        (error) => { console.error('Multiple upload error:', error); }
                    );
                };

                files.forEach((file, index) => {
                    if (file.type.startsWith('image/') || file.name.match(/\.(heic|heif|jpg|jpeg|png|webp)$/i)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = new Image();
                            img.onload = function() {
                                const maxDim = 1600;
                                let w = img.width, h = img.height;
                                if (w > maxDim || h > maxDim) {
                                    if (w > h) { h = Math.round((h * maxDim) / w); w = maxDim; }
                                    else { w = Math.round((w * maxDim) / h); h = maxDim; }
                                }
                                const canvas = document.createElement('canvas');
                                canvas.width = w; canvas.height = h;
                                const ctx = canvas.getContext('2d');
                                ctx.drawImage(img, 0, 0, w, h);
                                canvas.toBlob(function(blob) {
                                    if (!blob) {
                                        compressedFiles.push(file);
                                    } else {
                                        const newName = (file.name || `foto_${index}`).replace(/\.[^/.]+$/, '') + '.jpg';
                                        compressedFiles.push(new File([blob], newName, { type: 'image/jpeg' }));
                                    }
                                    processed++;
                                    if (processed === files.length) uploadAll();
                                }, 'image/jpeg', 0.82);
                            };
                            img.onerror = function() {
                                compressedFiles.push(file);
                                processed++;
                                if (processed === files.length) uploadAll();
                            };
                            img.src = e.target.result;
                        };
                        reader.onerror = function() {
                            compressedFiles.push(file);
                            processed++;
                            if (processed === files.length) uploadAll();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        compressedFiles.push(file);
                        processed++;
                        if (processed === files.length) uploadAll();
                    }
                });
            };
        </script>

        <!-- ===== GLOBAL PHOTO LIGHTBOX & CAROUSEL ===== -->
        @include('components.global-lightbox')

        <script>
            // ===== PWA SERVICE WORKER & STANDALONE DETECTOR =====
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(reg) {
                        console.log('PWA ServiceWorker registrado con éxito:', reg.scope);
                    }).catch(function(err) {
                        console.log('PWA ServiceWorker error:', err);
                    });
                });
            }

            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                document.body.classList.add('is-standalone');
            }
        </script>

        @livewireScripts
        <script>
            // ===== LIVEWIRE 3 ANTI-FREEZE & AUTOMATIC SESSION REFRESH =====
            document.addEventListener('livewire:init', () => {
                // Handle 419 (Page Expired / Token Timeout) or 401 (Unauthorized) seamlessly
                Livewire.hook('request', ({ fail }) => {
                    fail(({ status, preventDefault }) => {
                        if (status === 419 || status === 401) {
                            preventDefault();
                            console.warn('Sesión expirada o token CSRF caducado. Recargando página para restaurar conexión...');
                            window.location.reload();
                        }
                    });
                });
            });

            // ===== MOBILE APP RESUME / VISIBILITY CHECK =====
            (function() {
                let lastActiveTimestamp = Date.now();

                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        const inactiveElapsed = Date.now() - lastActiveTimestamp;
                        // Si la app estuvo minimizada o bloqueada por más de 30 minutos, refrescar suavemente
                        if (inactiveElapsed > 30 * 60 * 1000) {
                            console.info('Retorno a la app tras inactividad prolongada. Actualizando vista...');
                            window.location.reload();
                        } else {
                            lastActiveTimestamp = Date.now();
                        }
                    } else {
                        lastActiveTimestamp = Date.now();
                    }
                });
            })();
        </script>
    </body>
</html>
