<?php 
//namespace Repositories;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaultCreateRequest;
use App\Models\Fault;
//use Validator; 
use Illuminate\Validation\Rule;
//use App\Repositories\Interfaces\FaultRepositoryInterface as FaultRepo;
use App\Repositories\FaultRepository as FaultRepo;
//use App\Repositories\FaultRepositoryInterface as FaultRepo;

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
        $data=$this->repository->GetAll();
        return response()->json($data,200);
        // $data=Fault::all();
        // return response()->json($data,200);
    }
    public function show($id)
    {
        $data=$this->repository->GetFault($id);
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

    public function store(FaultCreateRequest $request,Fault $fault)
    { 

         // $data=Fault::Create($request->all());
         $data= $this->repository->AddFault($request->all());
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
    public function update($id)
    {
       // return response()->json($id,209);
      //  $validation=self::Validation($id);    
    }

    public function destroy($id)
    {   // return response()->json($id,200);    
        $id=Fault::find($id);        
        if(isset($id))
        {           
            $isdel= $id->delete();
            return response()->json($isdel,200);
        }
        else
            return response()->json(false,404);
        
    }
    public function restore($id)
    {   // return response()->json($id,200);    
        $id=Fault::withTrashed()->find($id);        
        if(isset($id))
        {           
            $isdel= $id->restore();
            return response()->json($isdel,200);
        }
        else
            return response()->json(false,404);
        
    }
    public static function Validation2()
    {  
        return response()->json(request()->all(),209);
        $roles=[
            "description" =>  "required|min:4|unique:faults,description",
        ];
        $validated=Validator::make(request()->all(),self::roles());
    //     if($validated->fails())
    //         return response()->json($validated->errors(),400);
    //    else
    //     {
    //         $data=$validated->valid();
    //         if($id>0)
    //         {
    //             $fault= Fault::where('id',$id) ;              
    //             $data=$fault->update($data);
    //             return response()->json($data,202);
    //         }
    //         else
    //         {                
    //             $data=Fault::create($data);
    //             return response()->json($data,201);
    //         }
            

    //     }
        return $validated;
    }
    public static function roles()
    {
        return [

            "description" => ['required','min:5', Rule::unique('faults')] ,
        ];
    }
}
