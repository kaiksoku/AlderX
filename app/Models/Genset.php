<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genset extends Model
{
    protected $table = 'genset';

    protected $primaryKey = 'gen_id';

    protected $fillable = [
        'gen_numero',
        'gen_medida',
        'gen_consumo',
        'gen_estado',
    ];
}
