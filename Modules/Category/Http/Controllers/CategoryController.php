<?php

namespace Modules\Category\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Category\Constants\CategoryMessage;
use Modules\Category\Requests\StoreCategoryRequest;
use Modules\Category\Requests\UpdateCategoryRequest;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
    use ResponseTrait, UploadTrait;

    protected CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories (tree structure).
     */
    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryService->getTree();
            return $this->success(
                CategoryResource::collection($categories),
                CategoryMessage::CATEGORIES_FETCHED,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                $data['image'] = $this->upload($request->file('image'), 'categories');
            }

            $category = $this->categoryService->create($data);
            return $this->success(
                new CategoryResource($category),
                CategoryMessage::CATEGORY_CREATED,
                HttpCode::CREATED->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    /**
     * Display the specified category.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->categoryService->find($id);
            if (!$category) {
                return $this->error(CategoryMessage::CATEGORY_NOT_FOUND, HttpCode::NOT_FOUND->value);
            }
            
            $category->load('children', 'parent');

            return $this->success(
                new CategoryResource($category),
                CategoryMessage::CATEGORY_FOUND,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $category = $this->categoryService->find($id);
                if ($category && $category->image) {
                    $this->deleteFile($category->image);
                }
                $data['image'] = $this->upload($request->file('image'), 'categories');
            }

            $category = $this->categoryService->update($id, $data);
            return $this->success(
                new CategoryResource($category),
                CategoryMessage::CATEGORY_UPDATED,
                HttpCode::OK->value
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    /**
     * Remove the specified category.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->categoryService->delete($id);
            return $this->success([], CategoryMessage::CATEGORY_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
}
