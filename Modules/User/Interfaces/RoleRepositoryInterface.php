<?php

namespace Modules\User\Interfaces;

interface RoleRepositoryInterface
{
    public function findAll();
    public function find(int $id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function assignPermissions(int $id, array $permissions);
}
