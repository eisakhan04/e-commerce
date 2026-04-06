<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface UserServiceInterface extends BaseServiceInterface
{
    public function findAll(array $request);
}
