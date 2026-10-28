<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreSlide extends Model
{
    protected $fillable = ['eyebrow', 'title', 'description', 'image_path', 'link_label', 'link_url', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'sort_order' => 'integer'];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return Str::startsWith($this->image_path, ['https://', 'http://']) ? $this->image_path : asset('storage/'.$this->image_path);
    }
}
