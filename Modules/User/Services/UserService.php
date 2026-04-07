<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Interfaces\UserServiceInterface;
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
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function login(array $credentials)
    {
        $user = $this->repository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception('Invalid credentials');
        }

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function logout($user)
    {
        return $user->tokens()->delete();
    }
}
