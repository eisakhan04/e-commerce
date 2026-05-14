<?php

namespace Modules\Product\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Product\Constants\ProductMessage;
use Modules\Product\Requests\StoreProductRequest;
use Modules\Product\Requests\UpdateProductRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Interfaces\ProductServiceInterface;

class ProductController extends Controller
{
    use ResponseTrait, UploadTrait;

    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products (with search and filtering).
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $products = $this->productService->searchAndFilter($request->all());
            return $this->success(
                ProductResource::collection($products),
                ProductMessage::PRODUCTS_FETCHED,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $this->upload($request->file('thumbnail'), 'products/thumbnails');
            }

            $product = $this->productService->create($data);

            if ($request->hasFile('gallery')) {
                $galleryPaths = $this->uploadMultiple($request->file('gallery'), 'products/gallery');
                $this->productService->syncImages($product->id, $galleryPaths);
            }

            return $this->success(
                new ProductResource($product->load(['category', 'images'])),
                ProductMessage::PRODUCT_CREATED,
                HttpCode::CREATED->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->find($id);
            if (!$product) {
                return $this->error(ProductMessage::PRODUCT_NOT_FOUND, HttpCode::NOT_FOUND->value);
            }

            $product->load(['category', 'images']);

            return $this->success(
                new ProductResource($product),
                ProductMessage::PRODUCT_FOUND,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $product = $this->productService->find($id);

            if (!$product) {
                return $this->error(ProductMessage::PRODUCT_NOT_FOUND, HttpCode::NOT_FOUND->value);
            }
            
            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail) {
                    $this->deleteFile($product->thumbnail);
                }
                $data['thumbnail'] = $this->upload($request->file('thumbnail'), 'products/thumbnails');
            }

            $updatedProduct = $this->productService->update($id, $data);

            if ($request->hasFile('gallery')) {
                $galleryPaths = $this->uploadMultiple($request->file('gallery'), 'products/gallery');
                $this->productService->syncImages($id, $galleryPaths);
            }

            return $this->success(
                new ProductResource($updatedProduct->load(['category', 'images'])),
                ProductMessage::PRODUCT_UPDATED,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->delete($id);
            return $this->success([], ProductMessage::PRODUCT_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
}
