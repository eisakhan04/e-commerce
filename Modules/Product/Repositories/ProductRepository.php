<?php

namespace Modules\Product\Repositories;

use App\Repositories\BaseRepository;
use Modules\Product\Interfaces\ProductRepositoryInterface;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductImage;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Professional Search and Filter implementation
     */
    public function searchAndFilter(array $filters)
    {
        $query = $this->model->with(['category', 'images']);

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['featured'])) {
            $query->where('featured', $filters['featured']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Pagination handling
        $perPage = $filters['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

    /**
     * Sync product gallery images
     */
    public function syncImages(int $productId, array $images)
    {
        // Delete old non-primary images if needed, or just append
        // Implementation depends on frontend logic, here we append
        foreach ($images as $imagePath) {
            ProductImage::create([
                'product_id' => $productId,
                'image_path' => $imagePath,
                'is_primary' => false
            ]);
        }
    }
}
