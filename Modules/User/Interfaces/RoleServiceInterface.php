<?php

namespace Modules\User\Interfaces;

interface RoleServiceInterface
{
    public function findAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function assignPermissions($id, array $permissions);
}
