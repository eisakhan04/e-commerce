<?php

namespace Modules\Category\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get categories in a tree structure
     */
    public function getTree();
}
