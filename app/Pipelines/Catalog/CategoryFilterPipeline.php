<?php

namespace App\Pipelines\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryFilterPipeline
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
        if($this->request->filled('name') || $this->request->filled('q')) {
            $searchTerm = strtolower($this->request->name ?? $this->request->q);

            $theQuery->where(function ($query) use ($searchTerm) {
                foreach (get_languages() as $language) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"{$language->code}\"'))) LIKE ?", ["%{$searchTerm}%"]);
                    // can search tea,Tea,TEA
                }
            });
        }
        return $theQuery;
    }
}

