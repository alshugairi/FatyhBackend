<?php

namespace App\Pipelines\Settings;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PostFilterPipeline
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
        if($this->request->filled('type')) {
            $theQuery->where('type', $this->request->type);
        }
        return $theQuery;
    }
}

