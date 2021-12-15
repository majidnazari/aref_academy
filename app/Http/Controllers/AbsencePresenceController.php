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
        $data=$this->repository->getAll();
        return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->getAbsencePresence($id);
        return response()->json($data,200);
        
    }
    public function store(AbsencePresenceCreateRequest $request)
    { 

         $data= $this->repository->addAbsencePresence($request);
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
