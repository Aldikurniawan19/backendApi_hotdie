<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'stock',
        'category',
        'image_url',
        'sizes',
        'colors',
        'is_active',
        'is_popular',
        'is_trending',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'sizes' => 'array',
        'colors' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'is_trending' => 'boolean',
    ];
}
