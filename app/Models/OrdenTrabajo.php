<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'checklist' => 'array',
        'evidencia_antes' => 'array',
        'evidencia_despues' => 'array',
        'fecha_ingreso' => 'datetime',
        'fecha_entrega' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function repuestos()
    {
        return $this->hasMany(OtRepuesto::class);
    }
}
