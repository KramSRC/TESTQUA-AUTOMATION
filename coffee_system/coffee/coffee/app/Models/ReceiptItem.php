<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    protected $fillable = [
        'receipt_id',
        'product_name',
        'quantity',
        'price_at_purchase'
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
