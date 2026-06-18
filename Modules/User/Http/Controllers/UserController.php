<?php

namespace Modules\User\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\User\Constants\UserMessage;
use Modules\User\Constants\RoleMessage;
use Modules\User\Interfaces\UserServiceInterface;
use Modules\User\Requests\UserRequest;
use Modules\User\Requests\UserRoleRequest;
use Modules\User\Requests\LoginUserRequest;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    use ResponseTrait;

    protected UserService $userservice;

    public function __construct(UserServiceInterface $userservice)
    {
        $this->userservice = $userservice;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userservice->findAll($request->all());
            return $this->success($users, UserMessage::USERS_FETCHED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    public function show(int $id)
    {
        try {
            $user = $this->userservice->find($id);
            if (!$user) {
                return $this->error(UserMessage::USER_NOT_FOUND, HttpCode::NOT_FOUND->value);
            }
            return $this->success($user, UserMessage::USER_FOUND, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userservice->create($request->validated());
            return $this->success($user, UserMessage::USER_CREATED, HttpCode::CREATED->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function update(UserRequest $request, int $id)
    {
        try {
            $user = $this->userservice->update($id, $request->validated());
            return $this->success($user, UserMessage::USER_UPDATED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userservice->delete($id);
            return $this->success([], UserMessage::USER_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->userservice->logout($request->user());
            return $this->success([], UserMessage::USER_LOGGED_OUT, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }

    public function register(UserRequest $request)
    {
        try {
            $result = $this->userservice->register($request->validated());
            return $this->success($result, UserMessage::USER_CREATED, HttpCode::CREATED->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
    // public function register(Request $request)
    // {
    //     // Agar $request->all() khali hai toh isse check karein:
    //     return response()->json([
    //         'all_data' => $request->all(),
    //         'content' => $request->getContent(), // Ye dekhega ke raw body mein kya hai
    //         'content_type' => $request->header('Content-Type') // Ye check karega headers set hain ya nahi
    //     ]);
    // }


    public function login(LoginUserRequest $request)
    {
        try {
            $result = $this->userservice->login($request->validated());
            return $this->success($result, UserMessage::USER_LOGGED_IN, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNAUTHORIZED->value);
        }
    }

    public function assignRole(UserRoleRequest $request, int $id)
    {
        try {
            $user = $this->userservice->assignRole($id, $request->role);
            return $this->success($user, RoleMessage::ROLE_ASSIGNED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function removeRole(UserRoleRequest $request, int $id)
    {
        try {
            $user = $this->userservice->removeRole($id, $request->role);
            return $this->success($user, RoleMessage::ROLE_REMOVED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user()->load('roles');
            return $this->success($user, UserMessage::USER_FOUND, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::SERVER_ERROR->value);
        }
    }
}
