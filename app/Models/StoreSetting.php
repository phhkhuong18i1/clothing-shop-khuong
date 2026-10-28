<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = ['shop_name', 'phone', 'email', 'address', 'instagram_url', 'zalo_url', 'messenger_url', 'badge_featured', 'badge_best_seller', 'badge_sale'];

    public static function defaults(): array
    {
        return [
            'shop_name' => config('store.name'),
            'phone' => config('store.phone'),
            'email' => config('store.email'),
            'address' => config('store.address'),
            'instagram_url' => config('store.instagram'),
            'zalo_url' => config('store.zalo_url'),
            'messenger_url' => config('store.messenger_url'),
            'badge_featured' => config('store.badge_featured'),
            'badge_best_seller' => config('store.badge_best_seller'),
            'badge_sale' => config('store.badge_sale'),
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], static::defaults());
    }
}
