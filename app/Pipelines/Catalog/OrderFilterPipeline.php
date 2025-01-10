<?php

namespace App\Pipelines\Catalog;

use App\Enums\PlatformType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderFilterPipeline
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
        if($this->request->filled('platform')) {
            if ($this->request->platform === 'online') {
                $theQuery->where('platform', '!=', PlatformType::Pos);
            } else {
                $theQuery->where('platform', $this->request->platform);
            }
        }
        if($this->request->filled('status')) {
            $theQuery->where('status', $this->request->status);
        }
        if($this->request->filled('status_in')) {
            $theQuery->whereIn('status', $this->request->status_in);
        }
        return $theQuery;
    }
}

