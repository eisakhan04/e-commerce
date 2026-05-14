<?php

namespace Modules\Category\Repositories;

use App\Repositories\BaseRepository;
use Modules\Category\Interfaces\CategoryRepositoryInterface;
use Modules\Category\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Get categories in a tree structure (nested children)
     */
    public function getTree()
    {
        return $this->model->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order', 'asc')
            ->get();
    }
}
