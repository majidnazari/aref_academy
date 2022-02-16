<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AzmoonCreateRequest;
use App\Http\Requests\AzmoonEditRequest;
use App\Models\Azmoon;
use App\Repositories\AzmoonRepository as AzmoonRepo;
use App\Http\Resources\AzmoonErrorResource;

class AzmoonController extends Controller
{
    
        private $repository;
        public function __construct(AzmoonRepo $repository)
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
            $data=$this->repository->getAzmoon($id);
            return response()->json($data,200);
            
        }
        public function store(AzmoonCreateRequest $request)
        { 
    
             $data= $this->repository->addAzmoon($request);
                  return response()->json($data,200); 
        }
        public function update(AzmoonEditRequest $request,$id)
        {
            $azmoon=Azmoon::find($id);
            if($azmoon===null)
            {
                return new AzmoonErrorResource("not found to update.");
            }
            else
            {
                //return response()->json($request->all(),200);
                $data= $this->repository->updateAzmoon($request,$azmoon);
                return response()->json($data,200);      
            }
               
        }
    
        public function destroy($id)
        { 
           // $user=$this->repository->GetAzmoon($id);   
            $user=Azmoon::find($id);
    
           // return $user; 
            if(isset($user))
            {   
                //return $user;
                $data= $this->repository->deleteAzmoon($user);
                return response()->json($data,200);          
                // $isdel= $id->delete();
                // return response()->json($isdel,200);
            }
            else
                return response()->json(new AzmoonErrorResource("not found to delete"),404);         
        }   
   
}
