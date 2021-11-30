<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionEditRequest;
use App\Http\Requests\CourseSessionAddListOfDaysRequest;
use App\Models\CourseSession;
use App\Repositories\CourseSessionRepository as CourseSessionRepo;
use App\Http\Resources\CourseSessionErrorResource;



class CourseSessionController extends Controller
{
    private $repository;
    public function __construct(CourseSessionRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $data=$this->repository->GetAll();
        return response()->json($data,200);        
    }
    public function show($id)
    {
        $data=$this->repository->GetCourseSession($id);
        return response()->json($data,200);
        
    }
    public function store(CourseSessionCreateRequest $request)
    {         
         $data= $this->repository->AddCourseSession($request);
              return response()->json($data,200); 
    }
    public function update(CourseSessionEditRequest $request,$id)
    {
        $year=CourseSession::find($id);
        if($year===null)
        {
            return new CourseSessionErrorResource("not found to update.");
        }
        else
        {
            //return response()->json($request->all(),200);public
            $data= $this->repository->UpdateCourseSession($request,$year);
            return response()->json($data,200);      
        }
     
    }

    public function destroy($id)
    { 
       // $user=$this->repository->GetCourseSessions($id);   
        $user=CourseSession::find($id);

       // return $user; 
        if(isset($user))
        {   
            //return $user;
            $data= $this->repository->DeleteCourseSession($user);
            return response()->json($data,200);          
            // $isdel= $id->delete();
            // return response()->json($isdel,200);
        }
        else
            return response()->json(new CourseSessionErrorResource("not found to delete"),404);         
    }
   
    public function AddSessions(CourseSessionAddListOfDaysRequest $request)
    {
        //dd($request);
         $data=$this->repository->AddListOfDays($request);
         return response()->json($data,200);
        
    }
}
