<?php

namespace Modules\User\Services;

use App\Services\BaseService;
use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Interfaces\UserServiceInterface;

class UserService extends BaseService implements UserServiceInterface
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findAll(array $request)
    {
        return $this->repository->findAll($request);
    }
}
