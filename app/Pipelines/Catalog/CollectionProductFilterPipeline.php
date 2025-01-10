<?php

namespace App\Pipelines\Catalog;

use Illuminate\Http\Request;

class CollectionProductFilterPipeline
{
    /**
     * @param Request $request
     */
    public function __construct(private readonly Request $request)
    {

    }

    public function handle($query, \Closure $next): mixed
    {
        $theQuery = $next($query);
        if($this->request->filled('collection_id')) {
            $theQuery->where('collection_id', $this->request->collection_id);
        }
        return $theQuery;
    }
}

