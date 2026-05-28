<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'user_id',
        'product_category_id',
        'status',
        'reference',
        'data',
        'documents',
        'processed_at',
        'completed_at',
    ];

    protected $casts = [
        'data' => 'array',
        'documents' => 'array',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
