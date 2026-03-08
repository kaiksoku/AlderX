<?php

// app/Models/SolicitudDetalle.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Solicitud extends Model
{
    protected $table = 'detalle_solicitud';
     protected $primaryKey = 'det_id';

    protected $fillable = [
        'det_solicitud',
        'det_empleado',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'det_solicitud', 'soli_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'det_empleado', 'id');
    }
}
