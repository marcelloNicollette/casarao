<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'registro_pedido',
    ];

    // Relacionamento com o cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento com os produtos do pedido
    public function produtos()
    {
        return $this->hasMany(ProdutosPedido::class, 'pedido_id');
    }
}
