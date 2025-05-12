<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'image', 'category_id', 'linhaproduto_id', 'cod_produto', 'unidade', 'validade', 'observacao', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productLine()
    {
        return $this->belongsTo(LinhaProduto::class, 'linhaproduto_id');
    }
}
