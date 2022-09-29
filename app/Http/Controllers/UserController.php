<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
Use App\Http\Resources\UserResource;
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
       // dd("this is test");
        //return $user_id=auth()->guard('api')->user()->id;
        $users=User::where('id',$id)         
        ->with("group") 
        ->first();
        $result=[
            "key" => isset($users->group->type) ? $users->group->type : 0
        ];
        return $result;
        //extra comment
    //     $results = DB::table('users')
    //    ->join('groups', 'users.group_id', '=', 'groups.id')
    //    ->where('users.id',$id)
    //    ->pluck('type');
    //    return  $results;

    //    $user_type= User::with('group:id,type as key')->first();
    //     return $user_type->group;

        // User::where('id',$id)->with(['group' => function($query) {
        //     $query->where('name', '=', 'industry.industry_name');
        // }])->get();
        
        // try {
        //     $token="lll";
        //     //$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNWJlMjA3Yjk2YWY0NjY0NjZhOTdhODgwODVhMGMwMTU3ODU1MzRiYTljNGMxNzBlYjlhMzAyYjVlYzRlMjVmNjNmMmU1NDJmOTA3YTE3YmMiLCJpYXQiOjE2NTQ3NjI4MjIuNzU3NjQ0LCJuYmYiOjE2NTQ3NjI4MjIuNzU3NjQ5LCJleHAiOjE2NTYwNTg4MjIuNzAzMDYyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.VqmGxGQkkJxYgWUfN33AMfra1F6-lHX7L1d25TW8ppDewIFNgiAbBFAyQhYSY91M4dWyEDWwKbpHkyccmEe0RrGMl0YZ8LBuFjLDAqThuvdlJ7PGlYrNVVeyeBQBGKZJo_J0qBPTVtEv-I9NSfpuMQhqhMDX5PfMr6j8ry-jAt_NhTfH439pWs4iybEzKWjFBQrt8NYoTRp5fufDX4CRLZzVrggiWDMj9JNGOmmv8oMLVwWJeIXLXlZB6XElip5KP-yddwOOTFNvVRkemwDU8hiHdc0xo8so3ZeezwG5kO3J8-vSlgRndVIUmAj2tYQof0yqjV_bx1gLcyjzYi6paZVCjYNqBQufbL66MDuKH12tBuLpefw-GDfP_zq2t4csdV7sxFhIVU5u2xY9MGcRkpVv0bD75WsYuYKRkKkRlnfeSs0BAlQVxAQf9gOLI9foEkvLk2fh87RJ7TRSEfsY2xWKNXiJgpAbgq80eL5I34FHWm4pBeM4dPeaXvzw77NylHwdOx0pcwDU3_EsUQaZfJBtSRy2BjxgLvLEtB8PCce84M1hrZU_F0NRMzHcmSnTJ1oCkbp3EWFT_n3AiX_b3e_d5iqEpSx24FfLqz-3zrW8HcYA0AsxawFF5v1sHqqWEoonMJEpZ10VZNZuWVRoPPd3trMCVgtdstJWO_iURWc";
        // //return $token;
        //     // attempt to verify the credentials and create a token for the user
        //     $token = JWTAuth::getToken();
        //     $apy = JWTAuth::getPayload($token)->toArray();
        // } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    
        //     return response()->json(['token_expired'], 500);
    
        // } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
        //     return response()->json(['token_invalid'], 500);
    
        // } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    
        //     return response()->json(['token_absent' => $e->getMessage()], 500);
    
        // }
        // return $token;
        // // $data= DB::table('users')
        // // ->leftJoin('group_user','users.id','=','group_user.user_id')
        // // ->leftJoin('groups','group_user.user_id','=','groups.id')
        // // ->where('id',1)->get();
        // // return response()->json($data,200);
        // $user=User::where('deleted_at', null)->whereHas('group',function ($query){
        //     $query->where("groups.id",3);
        // })        
        // ->with('group')
        // ->get();
        // return $user;
       
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
        dd($request);
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
