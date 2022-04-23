<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;
use App\Models\AbsencePresence;
use App\Repositories\AbsencePresenceRepository as AbsencePresenceRepo;
use App\Http\Resources\AbsencePresenceErrorResource;
use App\Http\Resources\AbsencePresenceResource;
use App\Http\Resources\AbsencePresenceCollection;


class AbsencePresenceController extends Controller
{
    private $repository;
    public function __construct(AbsencePresenceRepo $repository)
    { 
        $this->repository = $repository;
    }
    public function index()
    {
        $data=$this->repository->getAll();
        return (new AbsencePresenceCollection($data))->additional([
            "error" => null
        ])->response()->setStatusCode(200);
        // if(! $data)
        // {
            
        // }
        // return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->getAbsencePresence($id);
        if(! $data)
        {
            return (new AbsencePresenceResource(null))->additional([
                "error" => ["absence presence" => "there is no any record with this id."]
            ])->response()->setStatusCode(400);
        }
        return (new AbsencePresenceResource($data))->additional([
            "error" => null
        ])->response()->setStatusCode(201);
       // return response()->json($data,200);
        
    }
    public function store(AbsencePresenceCreateRequest $request)
    { 

         $data= $this->repository->addAbsencePresence($request);
         if(! $data)
         {
             return (new AbsencePresenceResource(null))->additional([
                 "error" => ["absence presence" => "there is a problem to save data."]
             ])->response()->setStatusCode(400);
         }
         return (new AbsencePresenceResource($data))->additional([
             "error" => null
         ])->response()->setStatusCode(201);
       //  return response()->json($data,200); 
    }
    public function update(AbsencePresenceEditRequest $request,$id)
    {
        $absencepresence=AbsencePresence::find($id);
        if($absencepresence===null)
        {
            return new AbsencePresenceErrorResource("not found to update.");
        }
        else
        {
            //return response()->json($request->all(),200);
            $data= $this->repository->updateAbsencePresence($request,$absencepresence);
            return response()->json($data,200);      
        }
           
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetAbsencePresence($id);   
        $user=AbsencePresence::find($id);

       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->deleteAbsencePresence($user);
            return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return response()->json(new AbsencePresenceErrorResource("not found to delete"),404);         
    }   
}
