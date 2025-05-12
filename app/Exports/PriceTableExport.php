<?php

namespace App\Exports;

use App\Models\PriceTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;

class PriceTableExport implements FromCollection, WithHeadings
{
    protected $priceTable;

    public function __construct(PriceTable $priceTable)
    {
        $this->priceTable = $priceTable;
    }

    public function collection()
    {
        return $this->priceTable->products->map(function($product) {
            return [
                'Produto' => $product->title,
                'Preço' => $product->pivot->price
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Produto',
            'Preço'
        ];
    }
}
