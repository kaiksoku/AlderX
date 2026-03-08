<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si es diferente del plural del modelo
    protected $table = 'producto';

    protected $primaryKey = 'prod_id';

    // Campos que se pueden asignar de manera masiva (mass assignable)
    protected $fillable = [
        'prod_nombre',
        'prod_descripcion',
        'prod_codigo',
        'prod_cantidad',
        'prod_precio',
        'prod_categoria', // La clave foránea de la categoría
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'prod_categoria', 'cat_id');
    }

}
