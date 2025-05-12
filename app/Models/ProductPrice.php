<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    public function priceTable()
    {
        return $this->belongsTo(PriceTable::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->orderBy('title', 'asc');
    }
}
