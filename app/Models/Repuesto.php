<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $fillable = ['categoria_id', 'nombre', 'stock_actual', 'precio_costo', 'precio_venta'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
