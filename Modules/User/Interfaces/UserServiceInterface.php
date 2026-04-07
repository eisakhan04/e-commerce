<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface UserServiceInterface extends BaseServiceInterface
{
    public function findAll(array $request);
    public function register(array $data);
    public function login(array $credentials);
    public function logout($user);
}
