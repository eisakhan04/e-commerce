<?php

namespace Modules\User\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Modules\User\Constants\RoleMessage;
use Modules\User\Interfaces\RoleServiceInterface;
use Modules\User\Requests\StoreRoleRequest;
use Modules\User\Requests\UpdateRoleRequest;
use Modules\User\Requests\AssignPermissionsRequest;

class RoleController extends Controller
{
    use ResponseTrait;

    protected $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        try {
            $roles = $this->roleService->findAll();
            return $this->success($roles, RoleMessage::ROLES_FETCHED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->create($request->validated());
            return $this->success($role, RoleMessage::ROLE_CREATED, HttpCode::CREATED->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->find($id);
            return $this->success($role, RoleMessage::ROLE_FOUND, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error(RoleMessage::ROLE_NOT_FOUND, HttpCode::NOT_FOUND->value);
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->update($id, $request->validated());
            return $this->success($role, RoleMessage::ROLE_UPDATED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->delete($id);
            return $this->success([], RoleMessage::ROLE_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function assignPermissions(AssignPermissionsRequest $request, $id)
    {
        try {
            $role = $this->roleService->assignPermissions($id, $request->permissions);
            return $this->success($role, RoleMessage::PERMISSIONS_ASSIGNED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
}
