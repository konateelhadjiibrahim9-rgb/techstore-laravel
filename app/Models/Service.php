<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'profile',
        'icon',
        'is_active',
        'processing_time',
        'requirements',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requirements' => 'array',
    ];

    public function requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
