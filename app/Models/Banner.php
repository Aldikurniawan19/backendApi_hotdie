<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'tag', 'offer_text', 'description', 'image_url',
        'background_color', 'position', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
