<?php

namespace Modules\User\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface PermissionServiceInterface extends BaseServiceInterface
{
    public function findAll();
}
