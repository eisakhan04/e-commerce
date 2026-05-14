<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository;
use Modules\User\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function findAll()
    {
        return $this->all();
    }
}
