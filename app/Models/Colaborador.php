<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Colaborador extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = "colaboradores";

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'data_nascimento',
        'password', // Descomente este campo
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'colaborador_id');
    }
}
