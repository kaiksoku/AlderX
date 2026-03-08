<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';
    protected $primaryKey = 'soli_id';

    protected $fillable = [
        'soli_justificación',
        'soli_tiempo',
        'soli_restaurante',
        'soli_usuario',
        'soli_generacion',
        'soli_aceptacion',
        'soli_facturacion',
        'soli_semana',
        'soli_anio',
        'soli_boleta',
        'soli_estado',
        'soli_departamento',
    ];

    protected $dates = [
        'soli_generacion',
        'soli_aceptacion',
        'soli_facturacion',
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function restaurante()
    {
        return $this->belongsTo(Restaurantes::class, 'soli_restaurante', 'rest_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'soli_usuario');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamentos::class, 'soli_departamento', 'dep_id');
    }

}
