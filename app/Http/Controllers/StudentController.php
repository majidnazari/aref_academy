<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentEditRequest;
//use App\Models\StudentFault;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\StudentFaultRepositoryInterface as StudentFaultRepo;
use App\Repositories\StudentRepository as StudentRepo;
use App\Http\Resources\StudentErrorResource;

class StudentController extends Controller
{
    
    private $repository;
        public function __construct(StudentRepo $repository)
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
            $data=$this->repository->getStudentFault($id);
            return response()->json($data,200);
            
        }
        public function store(StudentCreateRequest $request)
        {         
             $data= $this->repository->addStudentFault($request);
                  return response()->json($data,200); 
        }
        public function update(StudentEditRequest $request,$id)
        {
            // $studentcontact=StudentFault::find($id);
            // if($studentcontact===null)
            // {
            //     return new StudentFaultErrorResource("not found to update.");
            // }
            // else
            // {
            //     //return response()->json($request->all(),200);
            //     $data= $this->repository->updateStudentFault($request,$studentcontact);
            //     return response()->json($data,200);      
            // }
               
        }
    
        public function destroy($id)
        { 
            // $user=$this->repository->GetStudentFault($id);   
            //     $studentcontact=StudentFault::find($id);
        
            //    // return $user; 
            //     if(isset($studentcontact))
            //     {   
            //         //return $user;
            //         $data= $this->repository->deleteStudentFault($studentcontact);
            //         return response()->json($data,200);          
                
            //     }
            //     else
            //         return response()->json(new StudentFaultErrorResource("not found to delete"),404);         
        }     

}
