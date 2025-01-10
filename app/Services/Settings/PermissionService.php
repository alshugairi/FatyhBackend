<?php

namespace App\Services\Settings;

use App\Repositories\Settings\PermissionRepository;
use App\Services\BaseService;
use Illuminate\{Support\Collection, Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Arr, Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class PermissionService extends BaseService
{
    public function __construct(PermissionRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function getPermissionsNames(): array
    {
        $permissions = [];
        foreach ($this->allPermissions() as $permission) {
            $permissions[] = $permission->name;
        }
        return $permissions;
    }

    /**
     * @return Collection
     */
    public function allPermissions(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * @return array
     */
    public function groupedPermissions(): array
    {
        $groupedPermissions = [];

        foreach ($this->allPermissions() as $permission) {
            [$category, $action] = explode('.', $permission->name);
            $permission['action'] = $action;
            $groupedPermissions[$category][] = $permission;
        }
        return $groupedPermissions;
    }
}
