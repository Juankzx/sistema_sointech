<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CashRegister extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Cierra automáticamente esta caja calculando los balances reales
     * a partir de los pagos (payments) registrados en ella.
     */
    public function autoClose(): void
    {
        if ($this->status !== 'open') {
            return;
        }

        $payments = $this->payments;

        // Calcular efectivo esperado
        $incomeCash = $payments->where('type', 'income')->where('payment_method', 'Efectivo')->sum('amount');
        $expenseCash = $payments->where('type', 'expense')->where('payment_method', 'Efectivo')->sum('amount');
        $expectedCash = (float)$this->opening_balance + $incomeCash - $expenseCash;

        // Calcular transferencias esperadas
        $incomeTransfer = $payments->where('type', 'income')->where('payment_method', 'Transferencia')->sum('amount');
        $expenseTransfer = $payments->where('type', 'expense')->where('payment_method', 'Transferencia')->sum('amount');
        $expectedTransfer = $incomeTransfer - $expenseTransfer;

        // Calcular tarjetas esperadas
        $cardMethods = ['Débito/Crédito', 'Débito', 'Crédito', 'Tarjeta'];
        $incomeCard = $payments->where('type', 'income')->whereIn('payment_method', $cardMethods)->sum('amount');
        $expenseCard = $payments->where('type', 'expense')->whereIn('payment_method', $cardMethods)->sum('amount');
        $expectedCard = $incomeCard - $expenseCard;

        $expectedTotal = $expectedCash + $expectedTransfer + $expectedCard;

        $this->update([
            'status'                  => 'closed',
            'closed_at'               => Carbon::now(),
            'expected_cash'           => $expectedCash,
            'expected_transfer'       => $expectedTransfer,
            'expected_card'           => $expectedCard,
            'expected_closing_balance'=> $expectedTotal,
            'closing_cash'            => $expectedCash,
            'closing_transfer'        => $expectedTransfer,
            'closing_card'            => $expectedCard,
            'closing_balance'         => $expectedTotal,
            'notes'                   => 'Cierre automático por cambio de fecha. Los montos de cierre fueron calculados en base a los movimientos registrados en el sistema.',
        ]);
    }

    /**
     * Cierra automáticamente todas las cajas abiertas de días anteriores.
     * Debe llamarse al inicio de cada carga de página que maneja cajas.
     */
    public static function autoCloseStaleRegisters(): void
    {
        $staleRegisters = static::where('status', 'open')
            ->whereDate('opened_at', '<', Carbon::today())
            ->get();

        foreach ($staleRegisters as $register) {
            $register->autoClose();
        }
    }
}
