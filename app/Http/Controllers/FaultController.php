<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fault;
use Validator;
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
        //dd($request);  
        // $validation = Validator::make($request->all(),[ 
        //     "description" => "required|min:3"            
        // ]); 
       // dd($validation);
        //$data=self::Validation();
    //     if($validation->fails())
    //         return response()->json($validation->errors(),400);
    //    else
    //     {

    //         return response()->json("the request is true",200);

    //     }
    }
    public static function Validation()
    {
        $roles=[
            "description" => "required|min:4|unique:faults,description",
        ];
        $validated=Validator::make(request()->all(),self::roles());
        if($validated->fails())
            return response()->json($validated->errors(),400);
       else
        {
            $data=$validated->valid();
            $data=Fault::create($data);
            return response()->json($data,200);

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
