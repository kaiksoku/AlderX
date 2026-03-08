<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si es diferente del plural del modelo
    protected $table = 'departamentos';

    protected $primaryKey = 'dep_id';

    // Campos que se pueden asignar de manera masiva (mass assignable)
    protected $fillable = [
        'dep_nombre',
    ];

    // Relación: un departamento tiene muchos empleados/usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'departamento', 'dep_id');
    }
}

