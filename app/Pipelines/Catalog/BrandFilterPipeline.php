<?php

namespace App\Pipelines\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BrandFilterPipeline
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
        if($this->request->filled('category_id')) {
            $theQuery->where('category_id', $this->request->category_id);
        }
        if($this->request->filled('status')) {
            $theQuery->where('status', $this->request->status);
        }
        return $theQuery;
    }
}

