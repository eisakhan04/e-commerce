<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Modules\User\Interfaces\RoleRepositoryInterface;
use Modules\User\Interfaces\RoleServiceInterface;

class RoleService extends BaseService implements RoleServiceInterface
{
    public function __construct(RoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function assignPermissions($id, array $permissions)
    {
        return $this->repository->assignPermissions($id, $permissions);
    }
}
