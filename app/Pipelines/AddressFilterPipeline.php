<?php

namespace App\Pipelines;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AddressFilterPipeline
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
        if($this->request->filled('user_id')){
            $theQuery->where('user_id', $this->request->user_id);
        }
        if($this->request->filled('type')){
            $theQuery->where('type', $this->request->type);
        }
        return $theQuery;
    }
}

