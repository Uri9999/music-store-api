<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FullTextSearch
{
    /**
     * Scope a query to perform a full-text search.
     *
     * @param Builder $query
     * @param string $columns
     * @param string $searchTerm
     * @return Builder
     */
    public function scopeFullTextSearch(Builder $query, string $searchTerm, array $columns = [])
    {
        if (empty($columns)) {
            $columns = $this->getFullTextColumns();
        }

        $columnsList = implode(',', $columns);

        return $query->whereRaw(
            "MATCH ({$columnsList}) AGAINST (? IN BOOLEAN MODE)",
            [$searchTerm]
        );
    }

    /**
     * Get the columns to perform full-text search on.
     *
     * @return array
     */
    public function getFullTextColumns(): array
    {
        if (property_exists($this, 'fullTextColumns')) {
            return $this->fullTextColumns;
        }

        throw new \Exception('Please define the "fullTextColumns" property in your model.');
    }
}
