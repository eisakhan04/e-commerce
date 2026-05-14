<?php

namespace Modules\Product\Services;

use App\Services\BaseService;
use Modules\Product\Interfaces\ProductRepositoryInterface;
use Modules\Product\Interfaces\ProductServiceInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Search and filter products
     */
    public function searchAndFilter(array $filters)
    {
        return $this->repository->searchAndFilter($filters);
    }

    /**
     * Sync gallery images
     */
    public function syncImages(int $productId, array $images)
    {
        return $this->repository->syncImages($productId, $images);
    }
}
