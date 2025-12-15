<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'product_id', 'status', 'quantity'];

    // Get the user who placed the order
    public function user() {
        return $this->belongsTo(User::class);
    }

    // app/Models/Order.php

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
