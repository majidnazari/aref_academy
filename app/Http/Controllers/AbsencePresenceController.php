<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;
use App\Models\AbsencePresence;
use App\Repositories\AbsencePresenceRepository as AbsencePresenceRepo;
use App\Http\Resources\AbsencePresenceErrorResource;

class AbsencePresenceController extends Controller
{
    private $repository;
    public function __construct(AbsencePresenceRepo $repository)
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
        $data=$this->repository->GetAbsencePresence($id);
        return response()->json($data,200);
        
    }
    public function store(AbsencePresenceCreateRequest $request)
    { 

         $data= $this->repository->AddAbsencePresence($request);
              return response()->json($data,200); 
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
            $data= $this->repository->UpdateAbsencePresence($request,$absencepresence);
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
            $data= $this->repository->DeleteAbsencePresence($user);
            return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return response()->json(new AbsencePresenceErrorResource("not found to delete"),404);         
    }   
}
