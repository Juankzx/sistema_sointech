<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'inventory_id',
        'quantity',
        'unit_cost',
        'subtotal'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
