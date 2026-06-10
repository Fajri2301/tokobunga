<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'site_logo',
        'site_favicon',
        'phone_number',
        'whatsapp_number',
        'email',
        'address',
        'google_maps_link',
        'instagram_url',
        'facebook_url',
        'footer_text'
    ];
}
