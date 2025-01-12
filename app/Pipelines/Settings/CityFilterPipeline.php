<?php

namespace App\Pipelines\Settings;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CityFilterPipeline
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
        if($this->request->filled('name')) {
            $theQuery->where('name', 'LIKE', '%'.$this->request->type.'%');
        }
        if($this->request->filled('country_id')) {
            $theQuery->where('country_id', $this->request->country_id);
        }
        return $theQuery;
    }
}

