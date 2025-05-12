<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosPedido extends Model
{
    use HasFactory;

    protected $table = 'produtos_pedido';

    protected $fillable = [
        'id',
        'pedido_id',
        'cod_produto',
        'produto',
        'qtd_status',
        'tipo_caixa',
        'qtd',
        'price',
    ];
}
