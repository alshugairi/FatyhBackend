<?php

namespace App\Services\Settings;

use App\Repositories\Settings\RoleRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class RoleService extends BaseService
{
    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }
}
