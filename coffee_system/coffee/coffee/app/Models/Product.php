<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
        'category_id',
        'stock_quantity'
    ];

    /**
     * RENAMED RELATIONSHIP
     * Renamed to 'categoryData' to avoid conflict with the empty 'category' DB column.
     */
    public function categoryData(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}