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
use App\Livewire\Settings\ManageSettings;
use App\Livewire\Users\ManageUsers;
use App\Livewire\CashRegisters\ManageCashRegister;
use App\Livewire\Pos\PointOfSale;
use App\Livewire\Pos\SalesHistory;
use App\Http\Controllers\PrintController;

// Public Client Tracking Route
Route::get('/seguimiento/{uuid}', TrackWorkOrder::class)->name('work-orders.track');
Route::get('/firmar/{token}', \App\Livewire\Public\ClientSignature::class)->name('client.signature');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    
    // Password Recovery & Setup Routes
    Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::middleware('role:admin,tecnico,recepcionista')->group(function () {
        Route::get('/caja', function() { return redirect()->route('pos.index'); })->name('cash-registers.index');
        Route::get('/pos', PointOfSale::class)->name('pos.index');
        Route::get('/pos/historial', function() { return redirect()->route('pos.index'); })->name('sales.history');
        Route::get('/nueva-ot', CreateWorkOrder::class)->name('work-orders.create');
        Route::get('/ordenes-trabajo', ListWorkOrders::class)->name('work-orders.index');

        // Finanzas
        Route::get('/finanzas/dashboard', \App\Livewire\Finance\Dashboard::class)->name('finance.dashboard');
        Route::get('/finanzas/libro-ventas', \App\Livewire\Finance\SalesBook::class)->name('finance.sales-book');
        Route::get('/finanzas/compras', \App\Livewire\Finance\ManagePurchases::class)->name('finance.purchases');

        Route::get('/clientes', ListClients::class)->name('clients.index');
        Route::get('/proveedores', \App\Livewire\Finance\ManageSuppliers::class)->name('suppliers.index');
        Route::get('/inventario', ManageInventory::class)->name('inventory.index');
        Route::get('/configuracion', ManageSettings::class)->name('settings.index');
        Route::get('/reportes', \App\Livewire\Reports\Dashboard::class)->name('reports.index');
    });
    Route::get('/usuarios', ManageUsers::class)->name('users.index')->middleware('role:admin');

    Route::get('/caja/{id}/print', [PrintController::class, 'cashRegister'])->name('caja.print');
    Route::get('/ot/{id}/print', [PrintController::class, 'workOrder'])->name('ot.print');
    Route::get('/ot/{id}/print-payment/{payment_id}', [PrintController::class, 'payment'])->name('ot.print-payment');

    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
