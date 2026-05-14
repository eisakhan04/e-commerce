<?php

namespace Modules\Category\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface CategoryServiceInterface extends BaseServiceInterface
{
    /**
     * Get categories in a tree structure
     */
    public function getTree();
}
