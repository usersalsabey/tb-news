<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\HeroSlide;

class NewsController extends Controller
{
    private function resolveImage(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }
        return asset('storage/' . $path);
    }

    private function resolveImages($images): array
    {
        if (empty($images)) return [];

        if ($images instanceof \Illuminate\Support\Collection) {
            return $images
                ->map(fn($img) => $this->resolveImage(
                    $img->path ?? $img->url ?? $img->image ?? $img->foto ?? $img->file_path ?? ''
                ))
                ->filter(fn($url) => $url !== '')
                ->values()
                ->toArray();
        }

        return array_values(array_filter(
            array_map(fn($img) => is_string($img) && $img !== '' ? $this->resolveImage($img) : null, (array) $images)
        ));
    }

    public function index()
    {
        $newsItems = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        $news = $newsItems->map(function ($item) {
            return [
                'slug'     => $item->slug,
                'title'    => $item->title,
                'excerpt'  => $item->excerpt ?? \Str::limit(strip_tags($item->content), 160),
                'date'     => $item->published_at?->translatedFormat('d M Y') ?? '-',
                'category' => $item->category ?? 'umum',
                'icon'     => $item->icon ? $this->resolveImage($item->icon) : null,
                'images'   => $this->resolveImages($item->images ?? []),
            ];
        })->toArray();

        $heroSlides = HeroSlide::getSlides('news');

        return view('news.index', compact('news', 'heroSlides'));
    }

    public function show($slug)
    {
        $item = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $news = [
            'slug'     => $item->slug,
            'title'    => $item->title,
            'excerpt'  => $item->excerpt ?? \Str::limit(strip_tags($item->content), 160),
            'content'  => $item->content,
            'date'     => $item->published_at?->translatedFormat('d M Y') ?? '-',
            'category' => $item->category ?? 'umum',
            'source'   => $item->source ?? 'Humas Polres Gunungkidul',
            'icon'     => $item->icon ? $this->resolveImage($item->icon) : null,
            'images'   => $this->resolveImages($item->images ?? []),
        ];

        $related = News::where('is_published', true)
            ->where('category', $item->category)
            ->where('slug', '!=', $slug)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get()
            ->map(fn($r) => [
                'slug'     => $r->slug,
                'title'    => $r->title,
                'date'     => $r->published_at?->translatedFormat('d M Y') ?? '-',
                'category' => $r->category ?? 'umum',
                'icon'     => $r->icon ? $this->resolveImage($r->icon) : null,
                'images'   => $this->resolveImages($r->images ?? []),
            ])->toArray();

        return view('news.show', compact('news', 'related'));
    }
}