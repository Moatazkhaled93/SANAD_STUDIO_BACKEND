<?php

namespace App\Contracts;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get published posts
     *
     * @param int $perPage
     * @return mixed
     */
    public function getPublished(int $perPage = 15);

    /**
     * Get featured posts
     *
     * @param int $limit
     * @return mixed
     */
    public function getFeatured(int $limit = 5);

    /**
     * Get posts by status
     *
     * @param string $status
     * @param int $perPage
     * @return mixed
     */
    public function getByStatus(string $status, int $perPage = 15);

    /**
     * Update post status
     *
     * @param int $id
     * @param string $status
     * @return mixed
     */
    public function updateStatus(int $id, string $status);

    /**
     * Search posts by title or content
     *
     * @param string $query
     * @param string $language
     * @param int $perPage
     * @return mixed
     */
    public function search(string $query, string $language = 'en', int $perPage = 15);
}
