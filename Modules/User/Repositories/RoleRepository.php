<?php

namespace Modules\User\Repositories;

use Modules\User\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function findAll()
    {
        return Role::with('permissions')->get();
    }

    public function find($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }

    public function assignPermissions($id, array $permissions)
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions($permissions);
        return $role->load('permissions');
    }
}
