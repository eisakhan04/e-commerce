<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Modules\User\Interfaces\PermissionRepositoryInterface;
use Modules\User\Interfaces\PermissionServiceInterface;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    public function __construct(PermissionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}
