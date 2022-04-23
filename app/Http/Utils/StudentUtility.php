<?php

namespace App\Http\Utils;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;




class StudentUtility
{
    public function getAllStudents()
    {
        //dd("academy reporsitory1111");      
        $response = Http::get(env('REMOTE_SERVER')."student_index");
       // dd( $response->body());        //dd($response->body());
       // dd($response->json());
        return $response->json();
        //return $user;
    }
    public function getStudent($id)
    {       
        $response = Http::get(env('REMOTE_SERVER')."student_show/$id");       
        return $response->json();       
    }
    public function addStudent(Request $request)
    {   
        $student=[
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,            
                    "phone" => $request->phone,                    
                    "major" => $request->major,
                    "egucation_level" => $request->egucation_level
        ] ; 
             
        $response = Http::post(env('REMOTE_SERVER')."student_store",$student); 
        return $response->json();
       
    }
    public function updateStudent(Request $request,int $id)
    {  
        
        $student=[
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,            
                    "phone" => $request->phone,                    
                    "major" => $request->major,
                    "egucation_level" => $request->egucation_level
        ] ;                
        $response = Http::put(env('REMOTE_SERVER')."student_update/$id",$student);
        //dd($response->body());
        return $response->json();
    }
    public function deleteStudent($id)
    { 
        $response = Http::delete(env('REMOTE_SERVER')."student_destroy/$id"); 
       // dd($response->body());      
        return $response->json();       
    }
    
    
}
