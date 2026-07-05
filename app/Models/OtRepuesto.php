<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OtRepuesto extends Model
{
    protected $fillable = ['orden_trabajo_id', 'repuesto_id', 'nombre_repuesto', 'cantidad', 'precio_costo', 'precio_venta'];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajo_id');
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }
}
