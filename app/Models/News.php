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
        'foto',
        'video_url',
        'video_path',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
        'foto'         => 'array',
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

    /**
     * Ambil embed URL YouTube / TikTok secara otomatis.
     * Mendukung format: youtu.be/xxx, youtube.com/watch?v=xxx,
     *                   youtube.com/shorts/xxx, tiktok.com/@xxx/video/xxx
     */
    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) return null;

        $url = $this->video_url;

        // YouTube watch
        if (preg_match('/youtube\.com\/watch\?v=([\w\-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        // YouTube short link
        if (preg_match('/youtu\.be\/([\w\-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        // YouTube Shorts
        if (preg_match('/youtube\.com\/shorts\/([\w\-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        // TikTok
        if (preg_match('/tiktok\.com\/@[\w.]+\/video\/(\d+)/', $url, $m)) {
            return 'https://www.tiktok.com/embed/v2/' . $m[1];
        }

        return $url; // fallback: kembalikan URL asli
    }
}