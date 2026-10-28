<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'alt_text', 'sort_order', 'is_primary'];
    protected function casts(): array { return ['sort_order' => 'integer', 'is_primary' => 'boolean']; }
    public function getUrlAttribute(): string
    {
        return Str::startsWith($this->image_path, ['https://', 'http://'])
            ? $this->image_path
            : Storage::disk('public')->url($this->image_path);
    }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
}
