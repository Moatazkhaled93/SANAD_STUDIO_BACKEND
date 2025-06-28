<?php

namespace App\Contracts;

interface PartnerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get partners by status
     *
     * @param string $status
     * @return mixed
     */
    public function getByStatus(string $status);

    /**
     * Update partner status
     *
     * @param int $id
     * @param string $status
     * @return mixed
     */
    public function updateStatus(int $id, string $status);
}
