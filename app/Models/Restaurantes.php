<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurantes extends Model
{
    use HasFactory;

    protected $table = 'restaurantes';

    protected $primaryKey = 'rest_id';
    
    protected $fillable = [
        'rest_nombre',
        'rest_correo',
        'rest_horarios',
    ];
}
