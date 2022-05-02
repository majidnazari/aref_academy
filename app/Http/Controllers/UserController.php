<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
Use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $repository;
    public function __construct(UserRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index2()
    {
       $data= DB::table('users')
        ->leftJoin('group_user','users.id','=','group_user.user_id')
        ->leftJoin('groups','group_user.user_id','=','groups.id')->get();
        return response()->json($data,200);        
    }
    public function index()
    {
        $data=$this->repository->getAll();
        return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->getUser($id);
        return response()->json($data,200);
        
    }
    public function store(UserCreateRequest $request)
    { 

         $data= $this->repository->addUser($request);
              return response()->json($data,200); 
    }
    public function update(UserEditRequest $request,User $user)
    {     
        //return response()->json($request->all(),200);
        $data= $this->repository->updateUser($request,$user);
        // return (new OrderDetailCollection($orderDetails))->additional([
        //     'errors' => null,
        // ])->response()->setStatusCode(200);
        //dd($data);
        if(!$data)    
        {
            return (new UserResource(null))->additional([
                "error" => "there is a problem to save data."
            ])->response()->setStatusCode(200);
        }
        return (new UserResource($data))->additional([
            "error" => null
        ])->response()->setStatusCode(200);
        //return response()->json($data,200);         
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetUser($id);   
        $user=User::find($id);
       // dd($user->all());
       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->deleteUser($user);
            if(!$data)    
            {
                return (new UserResource(null))->additional([
                    "error" => "there is a problem to delete user."
                ])->response()->setStatusCode(204);
            }
            return (new UserResource($user))->additional([
                "error" => ""
            ])->response()->setStatusCode(200);
            //return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return (new UserResource(null))->additional([
                "error" => "there is a problem to find the user."
            ])->response()->setStatusCode(204);
            //return response()->json(false,404);         
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
