<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'author',
        'cover_image',
        'is_featured',
        'status',
        'published_at'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'content' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
            self::STATUS_ARCHIVED
        ];
    }

    // Helper methods for multilingual content
    public function getTitleForLanguage(string $language = 'en'): string
    {
        return $this->title[$language] ?? '';
    }

    public function getDescriptionForLanguage(string $language = 'en'): string
    {
        return $this->description[$language] ?? '';
    }

    public function getContentForLanguage(string $language = 'en'): string
    {
        return $this->content[$language] ?? '';
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
