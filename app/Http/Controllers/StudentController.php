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
            $data=$this->repository->getStudent($id);
            return response()->json($data,200);
            
        }
        public function store(StudentCreateRequest $request)
        {                    
             $data= $this->repository->addStudent($request);
                  return response()->json($data,200); 
        }
        public function update(StudentEditRequest $request,$id)
        {            
            $data= $this->repository->updateStudent($request,$id);
            //dd($data->resource);
            if($data->resource)
            {
                return response()->json($data,200);
            }
            return response()->json(new StudentErrorResource("not found to edit",404));
             
        }
    
        public function destroy($id)
        { 
            $data= $this->repository->deleteStudent($id); 
            
            if($data)          
            {
                return response()->json($data,200); 

            }
            //dd($data);
            return response()->json(new StudentErrorResource("not found to delete",404));   
                  
        }     

}
