<?php

namespace Modules\User\Http\Controllers;

use App\Enums\HttpCode;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\User\Constants\UserMessage;
use Modules\User\Interfaces\UserServiceInterface;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    use ResponseTrait;

    protected $userservice;

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

    public function show($id)
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

    public function store(Request $request)
    {
        try {
            $user = $this->userservice->create($request->all());
            return $this->success($user, UserMessage::USER_CREATED, HttpCode::CREATED->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userservice->update($id, $request->all());
            return $this->success($user, UserMessage::USER_UPDATED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userservice->delete($id);
            return $this->success([], UserMessage::USER_DELETED, HttpCode::OK->value);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), HttpCode::UNPROCESSABLE->value);
        }
    }
}
