<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'part_type', 'description', 'product_info', 'color',
        'quantity', 'part_number', 'single_price', 'bulk_price',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
