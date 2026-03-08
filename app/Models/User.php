<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;


    protected $fillable = [
        'name',
        'email',
        'password',
        'departamento', // La clave foránea de la departmantos
        'recinto',
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Nombre_Departamento()

    {
    return $this->belongsTo(Departamentos::class, 'departamento', 'dep_id');
    }
    
    public function Nombre_Recinto()
    {
    return $this->belongsTo(Recintos::class, 'recinto', 'reci_id');
    }

}


