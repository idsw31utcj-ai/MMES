<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // El campo de la tabla 'users' para la clave primaria
    protected $primaryKey = 'id';

    // Los atributos que son asignables en masa
    protected $fillable = [
        'username',
        'password',
        'clock_number',
        'status', // Asegúrate de que este campo se corresponda con tu base de datos
    ];

    // Los atributos que deberían ser ocultos para los arrays
    protected $hidden = [
        'password',
    ];

    // Los atributos que deberían ser mutados a tipos de datos específicos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
