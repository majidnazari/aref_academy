<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GatesController extends Controller
{
    public function index()
    {
        $data=Gate::all();
        return response()->json($data,200);
    }
    public function show($id)
    {
        $data=Gate::find($id);
        return response()->json($data,201);
    }
    public function showAll()
    {
        //$data=Gate::withTrashed()->get();
        //$data=Gate::onlyTrashed()->get();
        $data=Gate::all();
        return response()->json($data,201);
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
        $id=Gate::find($id);        
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
        $id=Gate::withTrashed()->find($id);        
        if(isset($id))
        {           
            $isdel= $id->restore();
            return response()->json($isdel,200);
        }
        else
            return response()->json(false,404);
        
    }
    public static function Validation($id=0)
    { 
        $validated=Validator::make(request()->all(),self::roles());
        if($validated->fails())
            return response()->json($validated->errors(),400);
       else
        {
            $data=$validated->valid();
            if($id>0)
            {
                $Gate= Gate::where('id',$id) ;              
                $data=$Gate->update($data);
                return response()->json($data,202);
            }
            else
            {                
                $data=Gate::create($data);
                return response()->json($data,201);
            }
            

        }
        return $validated;
    }
    public static function roles()
    {
        return [

            "description" => ['required'] ,
            "name" => ['required', Rule::unique('Gates')] ,
            //"user_id" => ['required', Rule::unique('Gates')] ,
        ];
    }
}
