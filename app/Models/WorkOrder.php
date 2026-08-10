<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'checklist'      => 'array',
        'terms_accepted' => 'boolean',
        'delivered_at'   => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Inventory::class, 'inventory_work_order')
                    ->withPivot('quantity', 'price_at_time')
                    ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(WorkOrderImage::class);
    }

    public function logs()
    {
        return $this->hasMany(WorkOrderLog::class)->orderBy('created_at', 'desc');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    public function components()
    {
        return $this->hasMany(WorkOrderComponent::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Etiqueta formateada con ícono para el Tipo de Equipo.
     */
    public function getDeviceTypeLabelAttribute(): string
    {
        return match (strtolower($this->device_type ?? '')) {
            'smartphone', 'celular' => '📱 Smartphone',
            'notebook', 'laptop'   => '💻 Notebook',
            'desktop', 'pc'        => '🖥️ PC Escritorio',
            'imac', 'mac'          => '🍎 Mac / iMac',
            'tablet', 'ipad'       => '📟 Tablet',
            'console', 'consola'   => '🎮 Consola',
            'smartwatch'           => '⌚ Smartwatch',
            'all_in_one', 'aio'    => '🖥️ All-in-One',
            default                => '⚙️ ' . ucfirst($this->device_type ?? 'Equipo'),
        };
    }

    /**
     * Calcula el valor total de la orden considerando estimated_cost, mano de obra y repuestos.
     */
    public function getCalculatedTotalAttribute(): float
    {
        $partsCost = (float)$this->parts->sum(fn($p) => $p->pivot->price_at_time * $p->pivot->quantity);
        $sumDetail = (float)$this->labor_cost + $partsCost;
        return max((float)$this->estimated_cost, $sumDetail);
    }

    /**
     * Retorna el saldo pendiente real considerando el abono y pagos registrados.
     */
    public function getPendingBalanceAttribute(): float
    {
        $totalPaid = (float)$this->payments->sum('amount');
        $downPayment = (float)$this->down_payment;
        $paid = max($totalPaid, $downPayment);
        return max(0, $this->calculated_total - $paid);
    }

    /**
     * Retorna la insignia y color de estado financiero de la OT.
     */
    public function getFinancialStatusBadgeAttribute(): array
    {
        if ($this->status === 'Rechazado') {
            return [
                'label' => 'Sin Cobro',
                'class' => 'text-gray-400 bg-gray-900 border-gray-700'
            ];
        }

        $total = $this->calculated_total;
        $balance = $this->pending_balance;

        if ($total <= 0) {
            return [
                'label' => 'Por Evaluar',
                'class' => 'text-amber-400 bg-amber-950/40 border-amber-500/30'
            ];
        }

        if ($balance > 0) {
            return [
                'label' => 'Pendiente: $' . number_format($balance, 0, ',', '.'),
                'class' => 'text-red-400 bg-red-950/50 border-red-500/30'
            ];
        }

        return [
            'label' => '✓ Pagado',
            'class' => 'text-emerald-400 bg-emerald-950/40 border-emerald-500/30'
        ];
    }

    /**
     * Retorna el estado de garantía de la OT.
     */
    public function getWarrantyStatusAttribute(): array
    {
        $months = $this->warranty_months;

        if ($months === null) {
            $settings = Setting::find(1);
            $months = $settings?->warranty_months ?? 3;
        }

        if ($months <= 0) {
            return [
                'status'         => 'none',
                'days_remaining' => null,
                'expiry_date'    => null,
                'months'         => 0,
            ];
        }

        if (!$this->delivered_at) {
            return [
                'status'         => 'none',
                'days_remaining' => null,
                'expiry_date'    => null,
                'months'         => $months,
            ];
        }

        $expiryDate = $this->delivered_at->copy()->addMonths($months);
        $now = Carbon::now();

        if ($now->lessThanOrEqualTo($expiryDate)) {
            return [
                'status'         => 'active',
                'days_remaining' => (int) $now->diffInDays($expiryDate),
                'expiry_date'    => $expiryDate,
                'months'         => $months,
            ];
        }

        return [
            'status'         => 'expired',
            'days_remaining' => 0,
            'expiry_date'    => $expiryDate,
            'months'         => $months,
        ];
    }
}
