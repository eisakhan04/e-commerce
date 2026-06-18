<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Interfaces\UserServiceInterface;
use Modules\User\Constants\UserMessage;
use Exception;

class UserService extends BaseService implements UserServiceInterface
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findAll(array $request)
    {
        return $this->repository->findAll($request);
    }

    public function register(array $data)
    {
        // return $data;
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);
        $user->assignRole('user');

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function login(array $credentials)
    {
        $user = null;
        if (!empty($credentials['email'])) {
            $user = $this->repository->findByEmail($credentials['email']);
        } elseif (!empty($credentials['phone'])) {
            $user = $this->repository->findByPhone($credentials['phone']);
        }

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception(UserMessage::INVALID_CREDENTIALS);
        }

        return [
            'user' => $user->load('roles'),
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function logout($user)
    {
        return $user->tokens()->delete();
    }

    public function assignRole($userId, $roleName)
    {
        $user = $this->repository->find($userId);
        $user->assignRole($roleName);
        return $user->load('roles');
    }

    public function removeRole($userId, $roleName)
    {
        $user = $this->repository->find($userId);
        $user->removeRole($roleName);
        return $user->load('roles');
    }
}
