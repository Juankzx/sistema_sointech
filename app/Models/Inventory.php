<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'inventory_work_order')
                    ->withPivot('quantity', 'price_at_time')
                    ->withTimestamps();
    }

    public function getCostAttribute(): float
    {
        return (float) ($this->attributes['cost_price'] ?? $this->attributes['cost'] ?? 0);
    }

    public function getPriceAttribute(): float
    {
        return (float) ($this->attributes['sale_price'] ?? $this->attributes['price'] ?? 0);
    }
}
