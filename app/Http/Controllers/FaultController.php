<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fault;
use Validator;
use SoftDeletes;
use Illuminate\Validation\Rule;

class FaultController extends Controller
{
    //

    public function index()
    {
        $data=Fault::all();
        return response()->json($data,200);
    }

    public function store()
    {        
        $validation=self::Validation();
       
    }
    public function update($id)
    {
       // return response()->json($id,209);
        $validation=self::Validation($id);    
    }

    public function destroy($id)
    {   // return response()->json($id,200);    
        $id=Fault::find($id);
        //return response()->json($id,200);

        $isdel= $id->delete();
        return response()->json($isdel,200);
    }
    public static function Validation($id=0)
    {  
        
        $roles=[
            "description" =>  "required|min:4|unique:faults,description,$id",
        ];
        $validated=Validator::make(request()->all(),self::roles());
        if($validated->fails())
            return response()->json($validated->errors(),400);
       else
        {
            $data=$validated->valid();
            if($id>0)
            {
                $fault= Fault::where('id',$id) ;              
                $data=$fault->update($data);
                return response()->json($data,201);
            }
            else
            {                
                $data=Fault::create($data);
                return response()->json($data,200);
            }
            

        }
        return $validated;
    }

    public static function roles()
    {
        return [

            "description" => ['required', Rule::unique('faults')] ,
        ];
    }
}
