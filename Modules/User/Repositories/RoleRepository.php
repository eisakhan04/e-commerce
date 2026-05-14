<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository;
use Modules\User\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findAll()
    {
        return $this->model->with('permissions')->get();
    }

    public function assignPermissions(int $id, array $permissions)
    {
        $role = $this->find($id);
        $role->syncPermissions($permissions);
        return $role->load('permissions');
    }
}
