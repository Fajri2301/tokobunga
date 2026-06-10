<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title', 
        'subtitle', 
        'description_1', 
        'description_2', 
        'image', 
        'creativity_title',
        'creativity_subtitle',
        'creativity_description',
        'image_creativity_left', 
        'image_creativity_right',
        'experience_years', 
        'clients_count', 
        'fresh_flowers_pct'
    ];
}
