<?php

namespace App\Pipelines\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AttributeOptionFilterPipeline
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
        if($this->request->filled('attribute_id')) {
            $theQuery->where('attribute_id', $this->request->attribute_id);
        }
        return $theQuery;
    }
}

