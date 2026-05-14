<?php

namespace Modules\Product\Interfaces;

use App\Interfaces\BaseServiceInterface;

interface ProductServiceInterface extends BaseServiceInterface
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
