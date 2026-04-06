<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository;
use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findAll(array $request)
    {
        return $this->all();
    }
}
