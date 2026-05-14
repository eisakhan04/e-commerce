<?php

namespace Modules\Product\Interfaces;

use App\Interfaces\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Search and filter products
     */
    public function searchAndFilter(array $filters);

    /**
     * Sync gallery images
     */
    public function syncImages(int $productId, array $images);
}
