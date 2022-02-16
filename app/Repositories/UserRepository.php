<?php

namespace App\Repositories;
//use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\UserResource;
//use bcrypt; 
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as userInterface;

//use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository  implements userInterface
{
    public function getAll(){
		
		return  UserResource::collection(User::all());
	}
 
	public function getUser($id){
		
		$data=User::find($id);		
		if(isset($data))
			return new UserResource($data);
		else 
			return ("not found");
		
	}

	public function addUser(UserCreateRequest $request){
       
       $data=[
        'password' => bcrypt($request->password),
        'email' => $request->email,
        'mobile' =>  $request->mobile,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'type' => $request->type
       ];
       $response= User::create($data);
       return new UserResource($response);       
	}	

    public function updateUser(UserEditRequest $request,User $user){
		
		$data=[
			'password' =>bcrypt($request->password),
			'email' => $request->email,
			'mobile' => $request->mobile,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'type' => $request->type,
		   ];
		  
		return 	$user->update($data);
	}
	public function deleteUser(User $user)
	{		
		return $user->delete();
		
	}
 
}
