<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll();
    public function assignPermissions(int $id, array $permissions);
}
