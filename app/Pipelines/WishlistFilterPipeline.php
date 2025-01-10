<?php

namespace App\Pipelines;

use Illuminate\Http\Request;

class WishlistFilterPipeline
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
        if($this->request->filled('product_id')){
            $theQuery->where('product_id', $this->request->product_id);
        }
        return $theQuery;
    }
}

