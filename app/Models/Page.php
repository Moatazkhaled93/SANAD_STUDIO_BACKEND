<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'section_name',
        'data',
        'is_active'
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean'
    ];

    // Helper method to get data for specific language
    public function getDataForLanguage(string $language = 'en'): array
    {
        return $this->data[$language] ?? [];
    }

    // Helper method to set data for specific language
    public function setDataForLanguage(string $language, array $data): void
    {
        $currentData = $this->data ?? [];
        $currentData[$language] = $data;
        $this->data = $currentData;
    }
}
