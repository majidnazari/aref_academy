<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearEditRequest;
use App\Models\Year;
use App\Repositories\YearRepository as YearRepo;
use App\Http\Resources\YearErrorResource;

class YearController extends Controller
{
    private $repository;
    public function __construct(YearRepo $repository)
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
        $data=$this->repository->getYear($id);
        return response()->json($data,200);
        
    }
    public function store(YearCreateRequest $request)
    { 

         $data= $this->repository->addYear($request);
              return response()->json($data,200); 
    }
    public function update(YearEditRequest $request,$id)
    {
        $year=Year::find($id);
        if($year===null)
        {
            return new YearErrorResource("not found to update.");
        }
        else
        {
            //return response()->json($request->all(),200);
            $data= $this->repository->updateYear($request,$year);
            return response()->json($data,200);      
        }
           
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetYear($id);   
        $user=Year::find($id);

       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->deleteYear($user);
            return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return response()->json(new YearErrorResource("not found to delete"),404);         
    }   
}
