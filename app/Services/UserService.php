<?php

namespace App\Services;

use App\Enums\UserType;
use App\Repositories\UserRepository;
use Illuminate\{Database\Eloquent\Model,
    Http\JsonResponse,
    Http\Request,
    Pipeline\Pipeline,
    Support\Arr,
    Support\Facades\Storage};
use Yajra\DataTables\DataTables;
use Exception;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): Model
    {
        $user = $this->repository->create(data: $this->excludeItem(data: $data));
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }
        return $user;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data, int $id): Model
    {
        $user = $this->repository->update(data: $this->excludeItem(data: $this->checkPassword(data: $data)), id: $id);
        if (isset($data['role'])) {
           $user->assignRole($data['role']);
        }
        return $user;
    }

    /**
     * @param array $data
     * @return array
     */
    public function storePhoto(array $data): array
    {
        if (!empty($data['avatar'])) {
            $filePath = $data['avatar']->store('user', 'public');
            $data['avatar'] = asset(Storage::url($filePath));
        } else {
            $data = Arr::except($data, ['avatar']);
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function checkPassword(array $data): array
    {
        if (empty($data['password'])) {
            $data = $this->excludeItem(data: $data, key: 'password');
        }
        return $data;
    }

    /**
     * @param array $data
     * @param array|string $key
     * @return array
     */
    private function excludeItem(array $data, array|string $key = 'role'): array
    {
        return Arr::except(array: $data, keys: $key);
    }

    /**
     * @param array $filters
     * @param array $relations
     * @return JsonResponse
     * @throws Exception
     */
    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->addColumn('role', function ($user) { return $user->roles ? $user->roles->value('name') : ''; })
            ->toJson();
    }
}
