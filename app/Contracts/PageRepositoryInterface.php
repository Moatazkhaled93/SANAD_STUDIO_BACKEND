<?php

namespace App\Contracts;

interface PageRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find page by section name
     *
     * @param string $sectionName
     * @return mixed
     */
    public function findBySection(string $sectionName);

    /**
     * Get active pages
     *
     * @return mixed
     */
    public function getActivePages();

    /**
     * Update page data for specific language
     *
     * @param string $sectionName
     * @param string $language
     * @param array $data
     * @return mixed
     */
    public function updatePageData(string $sectionName, string $language, array $data);
}
