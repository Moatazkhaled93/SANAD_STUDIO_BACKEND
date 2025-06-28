<?php

namespace App\Repositories;

use App\Models\Partner;
use App\Contracts\PartnerRepositoryInterface;

class PartnerRepository extends BaseRepository implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the model class
     */
    public function model(): string
    {
        return Partner::class;
    }

    /**
     * Get partners by status
     */
    public function getByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Update partner status
     */
    public function updateStatus(int $id, string $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
