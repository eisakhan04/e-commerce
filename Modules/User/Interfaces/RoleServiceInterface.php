<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface RoleServiceInterface extends BaseServiceInterface
{
    public function findAll();
    public function assignPermissions(int $id, array $permissions);
}
