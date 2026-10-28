<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'cover_image', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'published_at' => 'datetime'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) return null;
        return Str::startsWith($this->cover_image, ['https://', 'http://']) ? $this->cover_image : asset('storage/'.$this->cover_image);
    }
}
