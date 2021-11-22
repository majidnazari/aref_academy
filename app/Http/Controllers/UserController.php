<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use App\Repositories\UserRepository as UserRepo;


class UserController extends Controller
{
    private $repository;
    public function __construct(UserRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $data=$this->repository->GetAll();
        return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->GetUser($id);
        return response()->json($data,200);
        
    }
    public function store(UserCreateRequest $request)
    { 

         $data= $this->repository->AddUser($request);
              return response()->json($data,200); 
    }
    public function update(UserEditRequest $request,User $user)
    {
        //return response()->json($request->all(),200);
        $data= $this->repository->UpdateUser($request,$user);
        return response()->json($data,200);         
    }

    public function destroy($id)
    { 
        $user=$this->repository->GetUser($id);          
        if(isset($user))
        {   
            $data= $this->repository->DeleteUser($user);
            return response()->json($data,200); 
        }
        else
            return response()->json(false,404);
        
    }
    // public function restore($id)
    // {   // return response()->json($id,200);    
    //     $user=User::withTrashed()->find($id);  
    //     //$user=$this->repository->GetUser($id); 

    //     if(isset($user))
    //     {           
    //         $data= $this->repository->RestoreUser($user);
    //         return response()->json($data,200);
    //     }
    //     else
    //         return response()->json(false,404);
        
    // }
    
}
