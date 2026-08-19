<?php

namespace App\Livewire\CashRegisters;

use Livewire\Component;
use App\Models\CashRegister;
use App\Models\Payment;
use Carbon\Carbon;

class ManageCashRegister extends Component
{
    use \Livewire\WithPagination;

    public $activeRegister;
    public $opening_balance = 0;
    
    public $expected_closing_balance = 0;
    public $closing_balance = 0;
    
    public $expected_cash = 0;
    public $expected_transfer = 0;
    public $expected_card = 0;
    
    public $closing_cash = 0;
    public $closing_transfer = 0;
    public $closing_card = 0;
    
    public $closing_notes = '';

    public $showOpenModal = false;
    public $showCloseModal = false;
    
    public $searchRegister = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->loadActiveRegister();
    }

    public function updatedSearchRegister()
    {
        $this->resetPage();
    }

    public function loadActiveRegister()
    {
        // Cierre automático de cajas no cerradas de días anteriores (con cálculo de balances)
        CashRegister::autoCloseStaleRegisters();

        $this->activeRegister = CashRegister::where('status', 'open')
            ->whereDate('opened_at', Carbon::today())
            ->first();
            
        if ($this->activeRegister) {
            $this->calculateExpectedBalance();
        }
    }

    public function calculateExpectedBalance()
    {
        if (!$this->activeRegister) return;
        
        $payments = $this->activeRegister->payments;
        
        $incomeCash = $payments->where('type', 'income')->where('payment_method', 'Efectivo')->sum('amount');
        $expenseCash = $payments->where('type', 'expense')->where('payment_method', 'Efectivo')->sum('amount');
        $this->expected_cash = $this->activeRegister->opening_balance + $incomeCash - $expenseCash;

        $incomeTransfer = $payments->where('type', 'income')->where('payment_method', 'Transferencia')->sum('amount');
        $expenseTransfer = $payments->where('type', 'expense')->where('payment_method', 'Transferencia')->sum('amount');
        $this->expected_transfer = $incomeTransfer - $expenseTransfer;

        $cardMethods = ['Débito/Crédito', 'Débito', 'Crédito', 'Tarjeta'];
        $incomeCard = $payments->where('type', 'income')->whereIn('payment_method', $cardMethods)->sum('amount');
        $expenseCard = $payments->where('type', 'expense')->whereIn('payment_method', $cardMethods)->sum('amount');
        $this->expected_card = $incomeCard - $expenseCard;
        $this->expected_closing_balance = $this->expected_cash + $this->expected_transfer + $this->expected_card;
    }

    public function openCloseModal()
    {
        $this->calculateExpectedBalance();
        
        // Reset para arqueo asistido/ciego
        $this->closing_cash = '';
        $this->closing_transfer = '';
        $this->closing_card = '';
        $this->closing_notes = '';
        
        $this->showCloseModal = true;
    }

    public function openRegister()
    {
        $this->validate([
            'opening_balance' => 'required|numeric|min:0',
        ]);

        CashRegister::create([
            'user_id' => auth()->id(),
            'opening_balance' => $this->opening_balance,
            'status' => 'open',
            'opened_at' => now(),
        ]);

        $this->showOpenModal = false;
        $this->loadActiveRegister();
        session()->flash('message', 'Caja abierta exitosamente.');
    }

    public function closeRegister()
    {
        $this->validate([
            'closing_cash' => 'required|numeric|min:0',
            'closing_transfer' => 'required|numeric|min:0',
            'closing_card' => 'required|numeric|min:0',
        ]);

        $this->closing_balance = (float)$this->closing_cash + (float)$this->closing_transfer + (float)$this->closing_card;
        $diferencia = $this->closing_balance - $this->expected_closing_balance;

        // 1. Bloqueo si hay ventas esperadas y el usuario intenta cerrar en $0
        if ($this->expected_closing_balance > 0 && $this->closing_balance == 0) {
            $this->addError('closing_cash', '⚠️ No se puede cerrar la caja con $0 porque existen ventas registradas en el sistema ($' . number_format($this->expected_closing_balance, 0, ',', '.') . '). Ingresa el conteo físico real.');
            return;
        }

        // 2. Justificación obligatoria si existe descuadre / diferencia
        if (round($diferencia) != 0 && empty(trim($this->closing_notes))) {
            $tipoDiff = $diferencia < 0 ? 'Faltante' : 'Sobrante';
            $montoDiff = number_format(abs($diferencia), 0, ',', '.');
            $this->addError('closing_notes', "⚠️ Se detectó un {$tipoDiff} de \${$montoDiff} respecto al sistema. Debes ingresar la justificación en las Observaciones.");
            return;
        }

        $this->activeRegister->update([
            'expected_cash' => $this->expected_cash,
            'expected_transfer' => $this->expected_transfer,
            'expected_card' => $this->expected_card,
            'closing_cash' => (float)$this->closing_cash,
            'closing_transfer' => (float)$this->closing_transfer,
            'closing_card' => (float)$this->closing_card,
            'closing_balance' => $this->closing_balance,
            'expected_closing_balance' => $this->expected_closing_balance,
            'notes' => $this->closing_notes,
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        $this->showCloseModal = false;
        $this->loadActiveRegister();
        session()->flash('message', 'Caja cerrada exitosamente con arqueo validado.');
    }

    public function render()
    {
        $payments = [];
        if ($this->activeRegister) {
            $payments = $this->activeRegister->payments()->with(['workOrder', 'user'])->latest()->get();
        }

        // Historial de cajas cerradas (siempre visible)
        $query = CashRegister::with('user')->where('status', 'closed');
        
        if (!empty($this->searchRegister)) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->searchRegister . '%')
                  ->orWhereHas('user', function($qu) {
                      $qu->where('name', 'like', '%' . $this->searchRegister . '%');
                  });
            });
        }
        
        $recentRegisters = $query->latest()->paginate(10);

        return view('livewire.cash-registers.manage-cash-register', [
            'payments' => $payments,
            'recentRegisters' => $recentRegisters
        ])->layout('layouts.app');
    }
}