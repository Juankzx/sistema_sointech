<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;

class SalesHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Sale::with(['user', 'items']);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('client_name', 'like', '%' . $this->search . '%')
                  ->orWhere('uuid', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $sales = $query->latest()->paginate(15);

        return view('livewire.pos.sales-history', [
            'sales' => $sales,
        ])->layout('layouts.app');
    }
}
