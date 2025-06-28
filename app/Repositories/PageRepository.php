<?php

namespace App\Repositories;

use App\Models\Page;
use App\Contracts\PageRepositoryInterface;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the model class
     */
    public function model(): string
    {
        return Page::class;
    }

    /**
     * Find page by section name
     */
    public function findBySection(string $sectionName)
    {
        return $this->model->where('section_name', $sectionName)->first();
    }

    /**
     * Get active pages
     */
    public function getActivePages()
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Update page data for specific language
     */
    public function updatePageData(string $sectionName, string $language, array $data)
    {
        $page = $this->findBySection($sectionName);

        if (!$page) {
            // Create new page if it doesn't exist
            $page = $this->model->create([
                'section_name' => $sectionName,
                'data' => [$language => $data],
                'is_active' => true
            ]);
        } else {
            // Update existing page
            $page->setDataForLanguage($language, $data);
            $page->save();
        }

        return $page;
    }
}
