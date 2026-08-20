<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'default_price' => 'float',
        'is_active'     => 'boolean',
    ];

    public function workOrderServices()
    {
        return $this->hasMany(WorkOrderService::class);
    }

    /**
     * Retorna la etiqueta formateada con ícono para la categoría del servicio.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match (strtolower($this->category ?? 'general')) {
            'smartphone', 'celular' => '📱 Smartphones',
            'notebook', 'laptop'   => '💻 Notebooks',
            'desktop', 'pc'        => '🖥️ PC Escritorio',
            'mac', 'imac'          => '🍎 Mac / iMac',
            'tablet', 'ipad'       => '📟 Tablets',
            'console', 'consola'   => '🎮 Consolas',
            'smartwatch'           => '⌚ Smartwatches',
            'allinone', 'aio'      => '🖥️ All-in-One',
            'microsoldering'       => '🔬 Micro-soldadura',
            'software'             => '💻 Software / Optimización',
            default                => '⚙️ ' . ucfirst($this->category ?? 'General'),
        };
    }
}
