<?php

namespace App\Repositories;

use App\Models\Post;
use App\Contracts\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the model class
     */
    public function model(): string
    {
        return Post::class;
    }

    /**
     * Get published posts
     */
    public function getPublished(int $perPage = 15)
    {
        return $this->model->published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get featured posts
     */
    public function getFeatured(int $limit = 5)
    {
        return $this->model->featured()
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get posts by status
     */
    public function getByStatus(string $status, int $perPage = 15)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Update post status
     */
    public function updateStatus(int $id, string $status)
    {
        $data = ['status' => $status];

        // Set published_at when publishing
        if ($status === Post::STATUS_PUBLISHED) {
            $data['published_at'] = now();
        }

        return $this->update($id, $data);
    }

    /**
     * Search posts by title or content
     */
    public function search(string $query, string $language = 'en', int $perPage = 15)
    {
        return $this->model->where(function ($q) use ($query, $language) {
            $q->whereRaw("JSON_EXTRACT(title, '$.{$language}') LIKE ?", ["%{$query}%"])
              ->orWhereRaw("JSON_EXTRACT(content, '$.{$language}') LIKE ?", ["%{$query}%"]);
        })
        ->published()
        ->orderBy('published_at', 'desc')
        ->paginate($perPage);
    }
}
