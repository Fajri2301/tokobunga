<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class StorefrontCache
{
    public const KEYS = [
        'categories_all',
        'categories_global',
        'featured_products',
        'banners_hero_active',
        'ad_banner_iklan_active',
        'approved_reviews',
        'about_data',
        'home_categories',
    ];

    public static function forget(): void
    {
        foreach (self::KEYS as $key) {
            Cache::forget($key);
        }
    }
}
