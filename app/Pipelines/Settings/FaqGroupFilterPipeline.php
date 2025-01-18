<?php

namespace App\Pipelines\Settings;

use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqGroupFilterPipeline
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

        if($this->request->filled('is_active')) {
            $theQuery->where('is_active', $this->request->is_active);
        }
        return $theQuery;
    }
}

