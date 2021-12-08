<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Exports\DatatableExport;

class DatatableForResource
{
    // Original Query Builder Instance
    private $initialQuery;

    // Modified Query Builder Instance
    private $query;

    // Data Sort Column
    public $sortColumn;

    // Data Sort Order
    public $order;

    // Page Limit
    public $perPage = 10;

    // Page Number
    public $pageNo = 1;

    public function __construct($query)
    {

        if (!$query instanceof EloquentBuilder && !$query instanceof QueryBuilder) {
            throw new \Exception(
                "Argument 1 passed to App\Classes\Datatable::make() must be an instance of
                Illuminate\Database\Eloquent\Builder or Illuminate\Database\Query\Builder",
                1
            );
        }

        $this->initialQuery = $query;

        $this->query = $query;

        $this->getQueryFilters();
    }

    public static function make($query, string $resource)
    {
        if (!$query instanceof EloquentBuilder && !$query instanceof QueryBuilder) {
            throw new \Exception(
                "Argument 1 passed to App\Classes\Datatable::make() must be an instance of
                Illuminate\Database\Eloquent\Builder or Illuminate\Database\Query\Builder",
                1
            );
        }

      // Get Class Name
        $className = self::class;

      // Instanciate new Datatable Builder
        $datatable = new $className($query);

        $totalCount = $datatable->countTotal();

        $chunk = $datatable->getData();

        $chunk = $resource::collection($chunk);

        $pageCount = $datatable->countPages();

        $chunkCount = count($chunk);

        $data['data'] = [
            'data' => $chunk,
        ];

        $data['metadata'] = [
            'total_count' => $totalCount,
            'chunk_count' => $chunkCount,
            'page_count' => $pageCount,
            'page_no' => $datatable->pageNo,
            'per_page' => $datatable->perPage,
            'order' => $datatable->order,
        ];

        return $data;
    }

    private function getQuery()
    {
        return (clone $this->query);
    }

    private function countTotal()
    {
        return $this->getQuery()
        ->count();
    }

    private function countPages()
    {
        return ceil($this->countTotal() / $this->perPage);
    }

    private function getData()
    {
        $query = $this->getQuery();

        $query->offset(($this->pageNo - 1) * $this->perPage)
        ->limit($this->perPage);

        // Handle Sorting
        if ($this->sortColumn !== false && $this->order !== false) {
            if ($this->order == "ASC" || $this->order == "asc") {
                $sorted = $query->oldest($this->sortColumn);
            } else {
                $sorted = $query->latest($this->sortColumn);
            }
        }

        return $query->get();
    }

    private function getQueryFilters()
    {
        $this->order = request()->input('order') ?? null;

        $this->pageNo = request()->input('pageNo') ?? 1;

        $this->perPage = request()->input('perPage') ?? 10;
    }
}
