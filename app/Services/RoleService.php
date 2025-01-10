<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class RoleService extends BaseService
{
    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Model
    {
        $role = $this->repository->create(data: $this->excludePermissions(data: $this->setDefaultGuard( data: $data)));
        $this->syncPermissions(role: $role, data: $data);
        return $role;
    }

    public function update(array $data, int $id): Model
    {
        $role = $this->repository->update(data: $data, id: $id);
        $this->syncPermissions(role: $role, data: $data);
        return $role;
    }

    /**
     * @param array $data
     * @return array
     */
    private function excludePermissions(array $data): array
    {
        return Arr::except(array: $data, keys: "rolePermissions");
    }

    /**
     * @param array $data
     * @return array
     */
    private function setDefaultGuard(array $data): array
    {
        $data['guard_name'] = 'web';
        return $data;
    }

    /**
     * @param Role $role
     * @return array
     */
    public function getRolePermissions(Role $role): array
    {
        $permissions=[];
        foreach ($role->permissions as $permission){
            $permissions[]=$permission->name;
        }
        return $permissions;
    }

    /**
     * @param Role $role
     * @return array
     */
    public function getRolePermissionIds(Role $role): array
    {
        return $role->permissions()->pluck('name')->toArray();
    }

    public function syncPermissions(Role $role, array $data)
    {
        $role->syncPermissions([]);
        $role->givePermissionTo($data['role_permissions']);
    }
}
