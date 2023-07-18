<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_factura';

    protected $fillable = ['cedula', 'id_usuario', 'fecha_fac', 'subtotal_fac', 'descuento', 'iva', 'total'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cedula', 'cedula');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
