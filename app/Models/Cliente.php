<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre_completo', 'rut_dni', 'telefono', 'email'];

    public function ordenes()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}
