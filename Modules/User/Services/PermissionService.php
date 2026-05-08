<?php

namespace Modules\User\Services;

use Modules\User\Interfaces\PermissionRepositoryInterface;
use Modules\User\Interfaces\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{
    protected $repository;

    public function __construct(PermissionRepositoryInterface $repository)
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
}
