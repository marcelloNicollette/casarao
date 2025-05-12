<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes'; // Especifica o nome da tabela

    protected $fillable = [
        'razao_social',
        'email',
        'cnpj',
        'status',
        'colaborador_id',
        'price_tables_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function price_tables()
    {
        return $this->belongsTo(PriceTable::class);
    }
}
