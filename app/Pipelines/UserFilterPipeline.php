<?php

namespace App\Pipelines;

use Carbon\Carbon;
use Illuminate\Http\Request;

class UserFilterPipeline
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
        if($this->request->filled('q')){
            $searchTerm = $this->request->q;

            $theQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('phone', 'LIKE', '%'.$searchTerm.'%');
            });
        }
        if($this->request->filled('type')){
            $theQuery->where('type', $this->request->type);
        }
        return $theQuery;
    }
}

