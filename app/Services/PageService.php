<?php

namespace App\Services;

use App\Repositories\PageRepository;

class PageService extends BaseService
{
    private PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Get page content for specific section and language
     */
    public function getPageContent(string $sectionName, string $language = 'en'): array
    {
        $page = $this->pageRepository->findBySection($sectionName);

        if (!$page) {
            return [];
        }

        return $page->getDataForLanguage($language);
    }

    /**
     * Update page content for specific section and language
     */
    public function updatePageContent(string $sectionName, string $language, array $data): array
    {
        $page = $this->pageRepository->updatePageData($sectionName, $language, $data);
        return $page->getDataForLanguage($language);
    }

    /**
     * Get all active pages
     */
    public function getAllActivePages(): array
    {
        $pages = $this->pageRepository->getActivePages();
        $result = [];

        foreach ($pages as $page) {
            $result[$page->section_name] = $page->data;
        }

        return $result;
    }

    /**
     * Get page content for both languages
     */
    public function getPageContentBothLanguages(string $sectionName): array
    {
        $page = $this->pageRepository->findBySection($sectionName);

        if (!$page) {
            return [
                'en' => [],
                'ar' => []
            ];
        }

        return [
            'en' => $page->getDataForLanguage('en'),
            'ar' => $page->getDataForLanguage('ar')
        ];
    }
}
