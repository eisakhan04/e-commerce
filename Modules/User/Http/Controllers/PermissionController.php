<?php

namespace Modules\User\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Modules\User\Constants\PermissionMessage;
use Modules\User\Interfaces\PermissionServiceInterface;
use Modules\User\Requests\StorePermissionRequest;
use Modules\User\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    use ResponseTrait;

    protected $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        try {
            $permissions = $this->permissionService->findAll();
            return $this->success($permissions, PermissionMessage::PERMISSIONS_FETCHED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    public function store(StorePermissionRequest $request)
    {
        try {
            $permission = $this->permissionService->create($request->validated());
            return $this->success($permission, PermissionMessage::PERMISSION_CREATED, HttpCode::CREATED->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permissionService->find($id);
            return $this->success($permission, PermissionMessage::PERMISSION_FOUND, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error(PermissionMessage::PERMISSION_NOT_FOUND, HttpCode::NOT_FOUND->value);
        }
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        try {
            $permission = $this->permissionService->update($id, $request->validated());
            return $this->success($permission, PermissionMessage::PERMISSION_UPDATED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function destroy($id)
    {
        try {
            $this->permissionService->delete($id);
            return $this->success([], PermissionMessage::PERMISSION_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
}
