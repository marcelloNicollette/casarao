<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinhaProduto extends Model
{
    use HasFactory;

    protected $table = 'linhaproduto';
    
    protected $fillable = ['name', 'order'];
}
