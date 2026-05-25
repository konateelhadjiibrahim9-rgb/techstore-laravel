<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'sku',
        'description',
        'price',
        'stock_quantity',
        'image_path',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
