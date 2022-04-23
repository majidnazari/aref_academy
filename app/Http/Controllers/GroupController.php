<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupEditRequest;
use App\Models\Group;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\GroupRepositoryInterface as GroupRepo;
use App\Repositories\GroupRepository as GroupRepo;
use App\Http\Resources\GroupErrorResource;



class GroupController extends Controller
{
    private $repository;
    public function __construct(GroupRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $data=$this->repository->getAll();
        return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->getGroup($id);
        return response()->json($data,200);
        
    }
    public function store(GroupCreateRequest $request)
    { 

         $data= $this->repository->addGroup($request);
              return response()->json($data,200); 
    }
    public function update(GroupEditRequest $request,$id)
    {
        $gate=Group::find($id);
        if($gate===null)
        {
            return new GroupErrorResource("not found to update.");
        }
        else
        {
            //return response()->json($request->all(),200);
            $data= $this->repository->updateGroup($request,$gate);
            return response()->json($data,200);      
        }
           
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetGroup($id);   
        $user=Group::find($id);

       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->deleteGroup($user);
            return response()->json($data,200);         
           
        }
        else
            return response()->json(new GroupErrorResource("not found to delete"),404);         
    }   
}
