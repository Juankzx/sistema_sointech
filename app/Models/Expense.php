<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'document_type',
        'document_number',
        'supplier_rut',
        'supplier_name',
        'category',
        'description',
        'net_amount',
        'tax_amount',
        'total_amount',
        'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'net_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
