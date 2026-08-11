<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'uuid', 'document_type', 'client_name', 'client_rut', 'client_phone',
        'client_business_activity', 'client_address', 'client_city',
        'subtotal', 'tax_rate', 'tax_amount', 'total',
        'payment_method', 'user_id', 'cash_register_id', 'work_order_id',
        'sii_document_number', 'sii_status', 'sii_xml_url',
        'status', 'voided_at', 'voided_by', 'void_reason',
    ];

    protected $casts = [
        'voided_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeVoided($query)
    {
        return $query->where('status', 'voided');
    }

    // ── Helpers ─────────────────────────────────────────────
    public function isVoided(): bool
    {
        return $this->status === 'voided';
    }

    // ── Relationships ───────────────────────────────────────
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voidedByUser()
    {
        return $this->belongsTo(User::class, 'voided_by');
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
