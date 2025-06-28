<?php

namespace App\Services;

use App\Repositories\PartnerRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Partner;

class PartnerService extends BaseService
{
    private PartnerRepository $partnerRepository;

    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepository = $partnerRepository;
    }

    /**
     * Get all partners with pagination
     */
    public function getAllPartners(int $perPage = 15): LengthAwarePaginator
    {
        return $this->partnerRepository->paginate($perPage);
    }

    /**
     * Get partners by status
     */
    public function getPartnersByStatus(string $status): array
    {
        return $this->partnerRepository->getByStatus($status)->toArray();
    }

    /**
     * Create new partner inquiry
     */
    public function createPartner(array $data): Partner
    {
        return $this->partnerRepository->create($data);
    }

    /**
     * Update partner status
     */
    public function updatePartnerStatus(int $id, string $status): Partner
    {
        return $this->partnerRepository->updateStatus($id, $status);
    }

    /**
     * Get partner by ID
     */
    public function getPartnerById(int $id): Partner
    {
        return $this->partnerRepository->findById($id);
    }

    /**
     * Delete partner
     */
    public function deletePartner(int $id): bool
    {
        return $this->partnerRepository->delete($id);
    }

    /**
     * Get partner statistics
     */
    public function getPartnerStatistics(): array
    {
        $statuses = Partner::getStatuses();
        $stats = [];

        foreach ($statuses as $status) {
            $stats[$status] = count($this->partnerRepository->getByStatus($status));
        }

        $stats['total'] = array_sum($stats);

        return $stats;
    }
}
