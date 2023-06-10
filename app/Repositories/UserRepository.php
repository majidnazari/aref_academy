<?php

namespace App\Repositories;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollectionResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as userInterface;

/**
 * Class UserRepository.
 */
class UserRepository  implements userInterface
{
	public function getAll()
	{
		return  new UserCollectionResource(User::paginate(env('PAGE_COUNT')));
	}

	public function getUser($id)
	{

		$data = User::find($id);
		if (isset($data))
			return new UserResource($data);
		else
			return ("not found");
	}

	public function addUser(UserCreateRequest $request)
	{

		$data = [
			'password' => bcrypt($request->password),
			'email' => $request->email,
			'mobile' =>  $request->mobile,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'type' => $request->type
		];
		$response = User::create($data);
		return new UserResource($response);
	}

	public function updateUser(UserEditRequest $request, User $user)
	{

		$user->first_name = $request->first_name != "" ? $request->first_name : $user->first_name;
		$user->type = $request->type != "" ? $request->type : $user->type;
		$user->last_name = $request->last_name != "" ? $request->last_name : $user->last_name;
		$data = [
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'type' =>  $user->type,
		];

		if ($user->update($data))
			return $user;
		else
			return false;
	}
	public function deleteUser(User $user)
	{
		return $user->delete();
	}
}
