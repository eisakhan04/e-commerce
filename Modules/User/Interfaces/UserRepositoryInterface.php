<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll(array $request);

}
