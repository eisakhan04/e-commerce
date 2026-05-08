<?php

namespace Modules\User\Services;

use Modules\User\Interfaces\RoleRepositoryInterface;
use Modules\User\Interfaces\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function assignPermissions($id, array $permissions)
    {
        return $this->repository->assignPermissions($id, $permissions);
    }
}
