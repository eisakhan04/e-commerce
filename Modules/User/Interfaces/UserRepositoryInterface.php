<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email);
    public function findByPhone(string $phone);
    public function findAll(array $request);

}
