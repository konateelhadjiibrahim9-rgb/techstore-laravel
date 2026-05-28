<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'profile', // individual | enterprise
        'icon',
        'is_active',
        'processing_time',
        'requirements',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requirements' => 'array',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
