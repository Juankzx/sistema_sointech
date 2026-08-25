<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\WorkOrders\CreateWorkOrder;
use App\Livewire\WorkOrders\ListWorkOrders;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Clients\ListClients;
use App\Livewire\Inventory\ManageInventory;
use App\Livewire\Public\TrackWorkOrder;
use App\Livewire\Public\LandingPage;
use App\Livewire\Settings\ManageSettings;
use App\Livewire\Users\ManageUsers;
use App\Livewire\CashRegisters\ManageCashRegister;
use App\Livewire\Pos\PointOfSale;
use App\Livewire\Pos\SalesHistory;
use App\Livewire\Quotations\ListQuotations;
use App\Livewire\Quotations\CreateQuotation;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;

// Public Landing Page vs Subdomain Routing (taller.sointech.cl)
if (request()->getHost() && str_starts_with(request()->getHost(), 'taller.')) {
    Route::get('/', function () {
        return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
    });
} else {
    Route::get('/', LandingPage::class)->name('home');
}

// Public Client Tracking Routes (Protected against automated scanning)
Route::middleware('throttle:public-tracking')->group(function () {
    Route::get('/seguimiento/{uuid}', TrackWorkOrder::class)->name('work-orders.track');
    Route::get('/ot/track/{uuid}', function ($uuid) {
        return redirect()->route('work-orders.track', ['uuid' => $uuid]);
    });
});
Route::middleware('throttle:client-signature')->group(function () {
    Route::get('/firmar/{token}', \App\Livewire\Public\ClientSignature::class)->name('client.signature');
});

// Fallback Route for Storage Files (Garantiza previsualización de imágenes en Windows/XAMPP)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

// Guest Routes (Protected with Anti-Brute-Force Rate Limiting)
Route::middleware(['guest', 'throttle:login'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    
    // Password Recovery & Setup Routes
    Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

// Protected Routes (Workshop Staff & Admin System)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/mi-cuenta', Dashboard::class)->name('client.orders');

    Route::middleware('role:admin,tecnico,recepcionista')->group(function () {
        Route::get('/caja', \App\Livewire\CashRegisters\ManageCashRegister::class)->name('cash-registers.index');
        Route::get('/pos', PointOfSale::class)->name('pos.index');
        Route::get('/pos/historial', \App\Livewire\Pos\SalesHistory::class)->name('sales.history');
        Route::get('/nueva-ot', CreateWorkOrder::class)->name('work-orders.create');
        Route::get('/ordenes-trabajo', ListWorkOrders::class)->name('work-orders.index');

        // Cotizaciones Rápidas
        Route::get('/cotizaciones', ListQuotations::class)->name('quotations.index');
        Route::get('/cotizaciones/nueva', CreateQuotation::class)->name('quotations.create');
        Route::get('/cotizaciones/{id}/editar', CreateQuotation::class)->name('quotations.edit');

        // Finanzas
        Route::get('/finanzas/dashboard', \App\Livewire\Finance\Dashboard::class)->name('finance.dashboard');
        Route::get('/finanzas/libro-ventas', \App\Livewire\Finance\SalesBook::class)->name('finance.sales-book');
        Route::get('/finanzas/compras', \App\Livewire\Finance\ManagePurchases::class)->name('finance.purchases');

        Route::get('/clientes', ListClients::class)->name('clients.index');
        Route::get('/proveedores', \App\Livewire\Finance\ManageSuppliers::class)->name('suppliers.index');
        Route::get('/inventario', ManageInventory::class)->name('inventory.index');
        Route::get('/servicios', \App\Livewire\Services\ManageServices::class)->name('services.index');
        Route::get('/configuracion', ManageSettings::class)->name('settings.index');
        Route::get('/reportes', \App\Livewire\Reports\Dashboard::class)->name('reports.index');
        Route::get('/reportes/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
    });
    Route::get('/usuarios', ManageUsers::class)->name('users.index')->middleware('role:admin');

    Route::get('/caja/{id}/print', [PrintController::class, 'cashRegister'])->name('caja.print');
    Route::get('/ot/{id}/print', [PrintController::class, 'workOrder'])->name('ot.print');
    Route::get('/ot/{id}/print-thermal', [PrintController::class, 'workOrderThermal'])->name('ot.print-thermal');
    Route::get('/ot/{id}/print-payment/{payment_id}', [PrintController::class, 'payment'])->name('ot.print-payment');
    Route::get('/pos/sale/{id}/print', [PrintController::class, 'sale'])->name('sales.print');
    
    // Cotizaciones PDF & Impresión
    Route::get('/cotizaciones/{id}/print', [QuotationController::class, 'print'])->name('quotations.print');
    Route::get('/cotizaciones/{id}/download', [QuotationController::class, 'downloadPdf'])->name('quotations.download');

    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
