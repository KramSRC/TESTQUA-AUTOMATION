<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    // Explicitly tell Laravel to look for the "receipts" table
    protected $table = 'receipts';

    protected $fillable = [
        'user_id',
        'receipt_number',
        'total_amount',
        'customer_name',
        'phone_number',
        'address',        // <--- Make sure this is added
        'payment_method',
        'notes'
    ];
    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }
}
