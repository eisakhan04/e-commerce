<?php

namespace Modules\User\Repositories;

use Modules\User\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function findAll()
    {
        return Permission::all();
    }

    public function find($id)
    {
        return Permission::findOrFail($id);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update($id, array $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);
        return $permission->delete();
    }
}
