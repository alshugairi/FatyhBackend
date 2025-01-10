<?php

namespace App\Pipelines\Settings;

use Illuminate\Http\Request;

class SettingsFilterPipeline
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
        if($this->request->filled('prefix')) {
            $theQuery->where('key', 'LIKE', $this->request->prefix . '%');
        }
        return $theQuery;
    }
}

