<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GateCreateRequest;
use App\Http\Requests\GateEditRequest;
use App\Models\Gate;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\GateRepositoryInterface as GateRepo;
use App\Repositories\GateRepository as GateRepo;
use App\Http\Resources\GateErrorResource;



class GateController extends Controller
{
    private $repository;
    public function __construct(GateRepo $repository)
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
        $data=$this->repository->GetGate($id);
        return response()->json($data,200);
        
    }
    public function store(GateCreateRequest $request)
    { 

         $data= $this->repository->AddGate($request);
              return response()->json($data,200); 
    }
    public function update(GateEditRequest $request,$id)
    {
        $gate=Gate::find($id);
        if($gate===null)
        {
            return new GateErrorResource("not found to update.");
        }
        else
        {
            //return response()->json($request->all(),200);
            $data= $this->repository->UpdateGate($request,$gate);
            return response()->json($data,200);      
        }
           
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetGate($id);   
        $user=Gate::find($id);

       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->DeleteGate($user);
            return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return response()->json(new GateErrorResource("not found to delete"),404);         
    }   
}
