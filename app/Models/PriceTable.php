<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_prices')
            ->withPivot('price');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_price_tables');
    }
}
