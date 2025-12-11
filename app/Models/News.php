<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'is_published',
        'published_at',
        'author_id',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Relationship dengan User (author)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope untuk hanya news yang published
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope untuk filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Auto-generate slug dari title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
                
                // Ensure unique slug
                $count = static::where('slug', 'like', "{$news->slug}%")->count();
                if ($count > 0) {
                    $news->slug = "{$news->slug}-" . ($count + 1);
                }
            }
        });
    }

    /**
     * Accessor untuk formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : '-';
    }

    /**
     * Accessor untuk formatted views
     */
    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000) {
            return number_format($this->views / 1000, 1) . 'K';
        }
        return $this->views;
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get category badge color
     */
    public function getCategoryColorAttribute()
    {
        switch ($this->category) {
            case 'info':
                return 'blue';
            case 'tips':
                return 'green';
            case 'regulation':
                return 'red';
            case 'event':
                return 'purple';
            default:
                return 'gray';
        }
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        switch ($this->category) {
            case 'info':
                return 'Informasi';
            case 'tips':
                return 'Tips & Trik';
            case 'regulation':
                return 'Peraturan';
            case 'event':
                return 'Event';
            default:
                return 'Lainnya';
        }
    }
}
