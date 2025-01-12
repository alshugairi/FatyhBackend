<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Enums\UserType;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Model,
    Http\JsonResponse,
    Http\Request,
    Pipeline\Pipeline,
    Support\Arr,
    Support\Facades\Hash,
    Support\Facades\Storage,
    Support\Str};
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

    public function findOrCreateSocialUser(string $provider, string $providerId, array $userData): Model
    {
        $user = $this->repository->getModel()->newQuery()
            ->where(function ($query) use ($provider, $providerId, $userData) {
                $query->where([
                    'provider' => $provider,
                    'provider_id' => $providerId
                ])->orWhere('email', $userData['email']);
            })
            ->first();

        if (!$user) {
            $nameData = $this->parseFullName($userData['name']);
            $username = $this->generateUniqueUsername($userData['name']);
            $userData = array_merge($userData, [
                'username' => $username,
                'first_name' => $nameData['first_name'],
                'last_name' => $nameData['last_name'],
                'avatar' => $userData['avatar'] ?? null,
                'password' => Hash::make(Str::random(16)),
                'provider' => $provider,
                'provider_id' => $providerId,
                'status' => StatusEnum::Active->value,
                'type' => UserType::CLIENT->value,
                'verified' => true,
            ]);

            $user = $this->create($userData);
        }
        elseif (!$user->provider_id) {
            $user = $this->update([
                'provider' => $provider,
                'provider_id' => $providerId
            ], $user->id);
        }

        return $user;
    }

    private function generateUniqueUsername(string $name): string
    {
        $baseUsername = Str::slug($name);
        $username = $baseUsername;
        $counter = 1;

        while ($this->repository->getModel()->newQuery()
            ->where('username', $username)
            ->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function revokeAndCreateToken(User $user): string
    {
        $this->revokeTokens(user: $user);
        return $this->createToken(user: $user);
    }

    public function revokeTokens(User $user): void
    {
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }

    public function createToken(User $user): string
    {
        return $user->createToken(name: User::TokenName)->plainTextToken;
    }

    public function checkCodeAvailability(string $verificationCode): void
    {
        $model = $this->repository->getModel()->newQuery()
            ->where(column: 'verification_code', operator: '=', value: $verificationCode)
            ->where('verification_expires_at', '>', Carbon::now())
            ->first();

        if (!$model) {
            throw new Exception(__(key:'share.code_not_available'));
        }
    }

    public function getUserByEmail(string $email): ?Model
    {
        return $this->repository->getModel()->newQuery()
            ->where(column: 'email', operator: '=', value: $email)
            ->first();
    }

    public function getUserByPhone(string $phone): ?Model
    {
        return $this->repository->getModel()->newQuery()
            ->where(column: 'phone', operator: '=', value: $phone)
            ->first();
    }

    private function parseFullName(string $fullName): array
    {
        $nameParts = array_map('trim', explode(' ', $fullName));

        if (count($nameParts) === 1) {
            return [
                'first_name' => $nameParts[0],
                'last_name' => ''
            ];
        }

        $firstName = array_shift($nameParts);

        $lastName = implode(' ', $nameParts);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName
        ];
    }
}
