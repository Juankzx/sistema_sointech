<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'valid_until'  => 'date',
        'tax_included' => 'boolean',
        'subtotal'     => 'decimal:2',
        'tax_amount'   => 'decimal:2',
        'discount'     => 'decimal:2',
        'total'        => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Genera automáticamente un nuevo folio de cotización.
     */
    public static function generateQuoteNumber(): string
    {
        $year = date('Y');
        $last = self::whereYear('created_at', $year)->max('id') ?? 0;
        $next = $last + 1;
        return sprintf('COT-%s-%04d', $year, $next);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'borrador'   => 'bg-gray-100 text-gray-800 border-gray-300',
            'enviada'    => 'bg-blue-100 text-blue-800 border-blue-300',
            'aceptada'   => 'bg-green-100 text-green-800 border-green-300',
            'rechazada'  => 'bg-red-100 text-red-800 border-red-300',
            'convertida' => 'bg-purple-100 text-purple-800 border-purple-300',
            default      => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'borrador'   => 'Borrador',
            'enviada'    => 'Enviada',
            'aceptada'   => 'Aceptada',
            'rechazada'  => 'Rechazada',
            'convertida' => 'Convertida a OT',
            default      => ucfirst($this->status),
        };
    }

    public function getProductsTotalAttribute(): float
    {
        return (float) $this->items->where('type', 'producto')->sum(fn($i) => $i->quantity * $i->unit_price);
    }

    public function getServicesTotalAttribute(): float
    {
        return (float) $this->items->where('type', 'servicio')->sum(fn($i) => $i->quantity * $i->unit_price);
    }

    public function getRequiredDepositAttribute(): float
    {
        $prodTotal = $this->products_total;
        if ($prodTotal > 0) {
            return $prodTotal;
        }
        return round((float)$this->total * 0.5);
    }

    public function getPendingBalanceAttribute(): float
    {
        return max(0, (float)$this->total - $this->required_deposit);
    }
}
