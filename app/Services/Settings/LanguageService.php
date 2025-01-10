<?php

namespace App\Services\Settings;

use App\Repositories\Settings\LanguageRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class LanguageService extends BaseService
{
    public function __construct(LanguageRepository $repository)
    {
        parent::__construct($repository);
    }
}
