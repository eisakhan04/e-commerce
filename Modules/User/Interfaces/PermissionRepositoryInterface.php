<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll();
}
