<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chassis extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'chassis';

    // Primary Key personalizada
    protected $primaryKey = 'chass_id';

    // Si usas autoincrement (default true, pero lo dejamos claro)
    public $incrementing = true;

    // Tipo de la PK
    protected $keyType = 'int';

    // Campos asignables en masa
    protected $fillable = [
        'chass_numero',
        'chass_placa',
        'chass_ejes',
        'chass_medida',
        'chass_estructura',
        'chass_estado',
    ];

    // Casts (seguridad y limpieza)
    protected $casts = [
        'chass_ejes'    => 'integer',
        'chass_medida'  => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones (a futuro)
    |--------------------------------------------------------------------------
    |
    | Aquí irán cosas como:
    | - historial de movimientos
    | - asignaciones de genset
    | - historial de estados
    |
    */

    // Ejemplo futuro:
    // public function movimientos()
    // {
    //     return $this->hasMany(Movimiento::class, 'mov_chassis_id', 'chass_id');
    // }
}
