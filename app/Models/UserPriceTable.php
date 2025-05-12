<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPriceTable extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priceTable()
    {
        return $this->belongsTo(PriceTable::class);
    }
}
