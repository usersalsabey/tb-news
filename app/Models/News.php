<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
    'slug', 'title', 'excerpt', 'content',
    'category', 'icon', 'source',
    'published_at', 'is_published',
    'foto', // ← tambahkan ini
    ];

    protected $casts = [
    'published_at' => 'date',
    'is_published' => 'boolean',
    'foto'         => 'array', // ← tambahkan ini
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(NewsImage::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}