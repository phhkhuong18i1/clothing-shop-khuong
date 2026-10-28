<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'name', 'slug', 'sku', 'description', 'price', 'sale_price', 'stock_quantity', 'sizes', 'colors', 'is_published', 'is_featured', 'is_best_seller'];
    
    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'sale_price' => 'decimal:2', 'sizes' => 'array', 'colors' => 'array', 'is_published' => 'boolean', 'is_featured' => 'boolean', 'is_best_seller' => 'boolean'];
    }
    
    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if (blank($product->slug)) $product->slug = Str::slug($product->name);
        });
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
   
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
    
    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }
}
