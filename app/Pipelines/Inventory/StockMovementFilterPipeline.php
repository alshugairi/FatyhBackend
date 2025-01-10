<?php

namespace App\Pipelines\Inventory;

use Illuminate\Http\Request;

class StockMovementFilterPipeline
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
        if($this->request->filled('product_id')){
            $theQuery->where('product_id', $this->request->product_id);
        }
        if($this->request->filled('product_variant_id')){
            $theQuery->where('product_variant_id', $this->request->product_variant_id);
        }
        if($this->request->filled('reference_type')){
            $theQuery->where('reference_type', $this->request->reference_type);
        }
        if($this->request->filled('reference_id')){
            $theQuery->where('reference_id', $this->request->reference_id);
        }
        if($this->request->filled('type')){
            $theQuery->where('type', $this->request->type);
        }
        if($this->request->filled('movement_date')){
            $theQuery->where('movement_date', $this->request->movement_date);
        }
        if($this->request->filled('creator_id')){
            $theQuery->where('creator_id', $this->request->creator_id);
        }
        return $theQuery;
    }
}

