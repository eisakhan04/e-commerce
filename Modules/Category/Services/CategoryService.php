<?php

namespace Modules\Category\Services;

use App\Services\BaseService;
use Modules\Category\Interfaces\CategoryRepositoryInterface;
use Modules\Category\Interfaces\CategoryServiceInterface;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(CategoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get categories in a tree structure
     */
    public function getTree()
    {
        return $this->repository->getTree();
    }
}
