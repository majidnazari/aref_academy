<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;

use App\Models\User;
 
 Interface  UserRepositoryInterface{
	
	public function getAll(); 
	public function getUser($id);
	public function addUser(UserCreateRequest $request);
	public function updateUser(UserEditRequest $request,User $user);
	public function deleteUser(User $user);	
}

?>