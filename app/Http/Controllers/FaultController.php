<?php 
//namespace Repositories;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaultCreateRequest;
use App\Http\Requests\FaultEditRequest;
use App\Models\Fault;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\FaultRepositoryInterface as FaultRepo;
use App\Repositories\FaultRepository as FaultRepo;
use App\Http\Resources\FaultErrorResource;

class FaultController extends Controller
{
    //
    private $repository;
    public function __construct(FaultRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $data=$this->repository->getAll();
        return response()->json($data,200);
        // $data=Fault::all();
        // return response()->json($data,200);
    }
    public function show($id)
    {
        $data=$this->repository->getFault($id);
        return response()->json($data,200);
        // $data=Fault::find($id);
        // return response()->json($data,201);
    }
    // public function showAll()
    // {
    //     //$data=Fault::withTrashed()->get();
    //     //$data=Fault::onlyTrashed()->get();
    //     $data=Fault::all();
    //     return response()->json($data,201);
    // }

    public function store(FaultCreateRequest $request)
    { 

         // $data=Fault::Create($request->all());
         $data= $this->repository->addFault($request);
              return response()->json($data,200);
        //return response()->json($data,200);
    //     $rules=[
    //         "description" =>  "required|min:4|unique:faults,description",
    //     ];
    //     //return response()->json("f",207);
    // //    $data= $this->repository->AddFault($request);
    // //    return response()->json($data,200); 

    //         $validated =Validator::make(request()->all(),$rules) ;
    //        // return response()->json("f",207);
    //     // $validation=$request->validate([
    //     //     "description" => "required|min:4",
    //     // ]);
    //   // $validated=Validator::make(request()->all(),self::roles());
    //     if($validated->fails())
    //         return response()->json($validated->errors(),209);  
    //     elseif($validated->valid())
    //         return response()->json("this is valid",205);  
    //     else 
    //     return response()->json("this is unknow",206); 
       
    }
    public function update(FaultEditRequest $request,Fault $fault)
    {
        $data= $this->repository->updateFault($request,$fault);
        return response()->json($data,200);
       // return response()->json($id,209);
      //  $validation=self::Validation($id);    
    }

    public function destroy($id)
    { 
        $fault=Fault::find($id);

        // return $user; 
         if(isset($fault))
         {   
             //return $user;
             $data= $this->repository->deleteFault($fault);
             return response()->json($data,200); 
         }
         else
             return response()->json(new FaultErrorResource("not found to delete"),404); 
    }
    public function restore($id)
    {   // return response()->json($id,200);    
        $fault=Fault::withTrashed()->find($id);  
        //$fault=$this->repository->GetFault($id); 

        if(isset($fault))
        {           
            $data= $this->repository->restoreFault($fault);
            return response()->json($data,200);
        }
        else
            return response()->json(false,404);
        
    }
    // public static function Validation2()
    // {  
    //     return response()->json(request()->all(),209);
    //     $roles=[
    //         "description" =>  "required|min:4|unique:faults,description",
    //     ];
    //     $validated=Validator::make(request()->all(),self::roles());
    // //     if($validated->fails())
    // //         return response()->json($validated->errors(),400);
    // //    else
    // //     {
    // //         $data=$validated->valid();
    // //         if($id>0)
    // //         {
    // //             $fault= Fault::where('id',$id) ;              
    // //             $data=$fault->update($data);
    // //             return response()->json($data,202);
    // //         }
    // //         else
    // //         {                
    // //             $data=Fault::create($data);
    // //             return response()->json($data,201);
    // //         }
            

    // //     }
    //     return $validated;
    // }
    // public static function roles()
    // {
    //     return [

    //         "description" => ['required','min:5', Rule::unique('faults')] ,
    //     ];
    // }
}
