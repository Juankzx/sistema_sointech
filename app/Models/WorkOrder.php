<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkOrder extends Model
{
    /** @use HasFactory<\Database\Factories\WorkOrderFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'checklist'    => 'array',
        'terms_accepted' => 'boolean',
        'delivered_at' => 'datetime',
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
     * Retorna el estado de garantía de la OT.
     *
     * @return array{status: string, days_remaining: int|null, expiry_date: Carbon|null, months: int}
     *   status: 'active' | 'expired' | 'none'
     */
    public function getWarrantyStatusAttribute(): array
    {
        // Resolver meses de garantía (OT específica > configuración global)
        $months = $this->warranty_months;

        if ($months === null) {
            $settings = Setting::find(1);
            $months = $settings?->warranty_months ?? 3;
        }

        // Sin garantía configurada
        if ($months <= 0) {
            return [
                'status'        => 'none',
                'days_remaining' => null,
                'expiry_date'   => null,
                'months'        => 0,
            ];
        }

        // Solo aplica garantía si el equipo fue entregado
        if (!$this->delivered_at) {
            return [
                'status'        => 'none',
                'days_remaining' => null,
                'expiry_date'   => null,
                'months'        => $months,
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
