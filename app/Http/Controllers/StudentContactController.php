<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentContactCreateRequest;
use App\Http\Requests\StudentContactEditRequest;
use App\Models\StudentContact;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\StudentContactRepositoryInterface as StudentContactRepo;
use App\Repositories\StudentContactRepository as StudentContactRepo;
use App\Http\Resources\StudentContactErrorResource;

class StudentContactController extends Controller
{
        private $repository;
        public function __construct(StudentContactRepo $repository)
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
            $data=$this->repository->getStudentContact($id);
            return response()->json($data,200);
            
        }
        public function store(StudentContactCreateRequest $request)
        { 
           // dd("hi");
             $data= $this->repository->addStudentContact($request);
                  return response()->json($data,200); 
        }
        public function update(StudentContactEditRequest $request,$id)
        {
            $studentcontact=StudentContact::find($id);
            if($studentcontact===null)
            {
                return new StudentContactErrorResource("not found to update.");
            }
            else
            {
                //return response()->json($request->all(),200);
                $data= $this->repository->updateStudentContact($request,$studentcontact);
                return response()->json($data,200);      
            }
               
        }
    
        public function destroy($id)
        { 
           // $user=$this->repository->GetStudentContact($id);   
            $studentcontact=StudentContact::find($id);
    
           // return $user; 
            if(isset($studentcontact))
            {   
                //return $user;
                $data= $this->repository->deleteStudentContact($studentcontact);
                return response()->json($data,200);          
                // $isdel= $id->delete();
                // return response()->json($isdel,200);
            }
            else
                return response()->json(new StudentContactErrorResource("not found to delete"),404);         
        }   
  
}
