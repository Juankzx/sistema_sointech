<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\WorkOrder;
use App\Models\Payment;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function cashRegister($id)
    {
        $register = CashRegister::with(['user', 'payments'])->findOrFail($id);
        return view('print.cash-register', compact('register'));
    }

    public function workOrder($id)
    {
        $order = WorkOrder::with(['client', 'payments', 'parts'])->findOrFail($id);
        return view('print.work-order', compact('order'));
    }

    public function payment($id, $payment_id)
    {
        $order = WorkOrder::with(['client', 'parts'])->findOrFail($id);
        $payment = Payment::with(['user'])->findOrFail($payment_id);
        $appSettings = \App\Models\Setting::first();
        return view('print.payment', compact('order', 'payment', 'appSettings'));
    }

    public function sale($id)
    {
        $sale = \App\Models\Sale::with(['items', 'user'])->findOrFail($id);
        $companySettings = \App\Models\Setting::first();
        return view('print.pos-sale', compact('sale', 'companySettings'));
    }
}
