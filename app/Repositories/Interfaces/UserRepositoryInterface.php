<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;

use App\Models\User;
 
 Interface  UserRepositoryInterface{
	
	public function GetAll(); 
	public function GetUser($id);
	public function AddUser(UserCreateRequest $request);
	public function UpdateUser(UserEditRequest $request,User $user);
	public function DeleteUser(User $user);
	//public function RestoreUser(User $user);
 
	// more
}

?>