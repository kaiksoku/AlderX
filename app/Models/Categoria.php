<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si es diferente del plural del modelo
    protected $table = 'categoria';

    protected $primaryKey = 'cat_id';

    // Campos que se pueden asignar de manera masiva (mass assignable)
    protected $fillable = [
        'cat_nombre',
    ];

    // Relación: Una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'prod_categoria', 'cat_id');
    }
}
