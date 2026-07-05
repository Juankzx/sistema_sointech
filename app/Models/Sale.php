<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'uuid', 'document_type', 'client_name', 'client_rut', 'client_phone',
        'client_business_activity', 'client_address', 'client_city',
        'subtotal', 'tax_rate', 'tax_amount', 'total',
        'payment_method', 'user_id', 'cash_register_id',
        'sii_document_number', 'sii_status', 'sii_xml_url'
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

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }
}
