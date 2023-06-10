<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private $repository;
    public function __construct(UserRepo $repository)
    {
        $this->repository = $repository;
    }
    public function getUserType(int $id)
    {
        $users = User::where('id', $id)
            ->with("group")
            ->first();
        $result = [
            "key" => isset($users->group->type) ? $users->group->type : 0
        ];
        return $result;
    }
    public function index2()
    {
        $data = DB::table('users')
            ->leftJoin('group_user', 'users.id', '=', 'group_user.user_id')
            ->leftJoin('groups', 'group_user.user_id', '=', 'groups.id')->get();
        return response()->json($data, 200);
    }
    public function index()
    {
        $data = $this->repository->getAll();
        return response()->json($data, 200);
    }
    public function show($id)
    {
        $data = $this->repository->getUser($id);
        return response()->json($data, 200);
    }
    public function store(UserCreateRequest $request)
    {
        $data = $this->repository->addUser($request);
        return response()->json($data, 200);
    }
    public function update(UserEditRequest $request, User $user)
    {
        $data = $this->repository->updateUser($request, $user);
        if (!$data) {
            return (new UserResource(null))->additional([
                "error" => "there is a problem to save data."
            ])->response()->setStatusCode(200);
        }
        return (new UserResource($data))->additional([
            "error" => null
        ])->response()->setStatusCode(200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (isset($user)) {
            $data = $this->repository->deleteUser($user);
            if (!$data) {
                return (new UserResource(null))->additional([
                    "error" => "there is a problem to delete user."
                ])->response()->setStatusCode(204);
            }
            return (new UserResource($user))->additional([
                "error" => ""
            ])->response()->setStatusCode(200);
        } else
            return (new UserResource(null))->additional([
                "error" => "there is a problem to find the user."
            ])->response()->setStatusCode(204);
    }
}
