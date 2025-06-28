<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Post;

class PostService extends BaseService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Get all posts with pagination
     */
    public function getAllPosts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->postRepository->paginate($perPage);
    }

    /**
     * Get published posts
     */
    public function getPublishedPosts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->postRepository->getPublished($perPage);
    }

    /**
     * Get featured posts
     */
    public function getFeaturedPosts(int $limit = 5): array
    {
        return $this->postRepository->getFeatured($limit)->toArray();
    }

    /**
     * Get posts by status
     */
    public function getPostsByStatus(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return $this->postRepository->getByStatus($status, $perPage);
    }

    /**
     * Create new post
     */
    public function createPost(array $data): Post
    {
        return $this->postRepository->create($data);
    }

    /**
     * Update post
     */
    public function updatePost(int $id, array $data): Post
    {
        return $this->postRepository->update($id, $data);
    }

    /**
     * Update post status
     */
    public function updatePostStatus(int $id, string $status): Post
    {
        return $this->postRepository->updateStatus($id, $status);
    }

    /**
     * Get post by ID
     */
    public function getPostById(int $id): Post
    {
        return $this->postRepository->findById($id);
    }

    /**
     * Delete post
     */
    public function deletePost(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    /**
     * Search posts
     */
    public function searchPosts(string $query, string $language = 'en', int $perPage = 15): LengthAwarePaginator
    {
        return $this->postRepository->search($query, $language, $perPage);
    }

    /**
     * Get post statistics
     */
    public function getPostStatistics(): array
    {
        $statuses = Post::getStatuses();
        $stats = [];

        foreach ($statuses as $status) {
            $stats[$status] = $this->postRepository->getByStatus($status, 1)->total();
        }

        $stats['total'] = array_sum($stats);
        $stats['featured'] = count($this->postRepository->getFeatured(100));

        return $stats;
    }
}
