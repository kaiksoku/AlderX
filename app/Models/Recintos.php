<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recintos extends Model
{
    use HasFactory;

    protected $table = 'recintos';

    protected $primaryKey = 'reci_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'reci_nombre',
        'reci_descripcion',
        'reci_activo',
    ];
}
