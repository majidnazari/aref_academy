<?php

namespace App\Repositories;
//use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollectionResource;

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
		
		//return  UserResource::collection(User::all());
		return  new UserCollectionResource(User::paginate(env('PAGE_COUNT')));		
		//return  UserResource::collection(User::all());		
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
	
		$user->first_name= $request->first_name!="" ? $request->first_name : $user->first_name;
        $user->type= $request->type!="" ? $request->type : $user->type;
        //$user->mobile= $request->mobile!="" ? $request->mobile : $user->mobile;
       // $user->email= $request->email!="" ? $request->email : $user->email;
        $user->last_name= $request->last_name!="" ? $request->last_name : $user->last_name;
        //$user->first_name= $request->first_name!="" ? $request->first_name : $user->first_name;

		$data=[
			//'password' =>bcrypt($request->password),
			//'email' => $request->email,
			//'mobile' => $request->mobile,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'type' =>  $user->type,
		   ];
		  
		if($user->update($data))
		   return $user;
		else 
		return false;  
	}
	public function deleteUser(User $user)
	{		
		return $user->delete();
		
	}
 
}
