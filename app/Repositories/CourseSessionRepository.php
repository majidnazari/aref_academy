<?php

namespace App\Repositories;
//use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionEditRequest;
use App\Http\Requests\CourseSessionAddListOfDaysRequest;
use App\Http\Resources\CourseSessionResource;
use App\Http\Resources\CourseSessionErrorResource;
//use bcrypt; 
use App\Models\CourseSession;
use Carbon;
use App\Repositories\Interfaces\CourseSessionRepositoryInterface as userInterface;

//use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CourseSessionRepository.
 */
class CourseSessionRepository  implements userInterface
{
    public function GetAll(){
		//return CourseSession::all();
		return  CourseSessionResource::collection(CourseSession::all());
	}
 
	public function GetCourseSession($id){
		//return CourseSession::find($id);
		$data=CourseSession::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new CourseSessionResource($data);
		else 
        {           
            return new CourseSessionErrorResource("not found to fetch.");
        }
	}

	public function AddCourseSession(CourseSessionCreateRequest $request){
       
    //    $data=self::CourseSessionData();
    // $data=[
    //     'name' =>$request->name,
    //     'active' => $request->active,
    //     //'course' => $request->course,			
    //    ];
        $data=self::CourseSessionData($request);
        //dd($data);
       // dd($request->toarray());
       //dd($request->teacher_id);
       $response= CourseSession::create($data);
       return new CourseSessionResource($response);       
	}	

    public function UpdateCourseSession(CourseSessionEditRequest $request,CourseSession $CourseSession){
		//dd("this is user edit");
		//dd($course);
		$data=self::CourseSessionData($request);
		   //dd($request->all());
          // dd($data);
	    $courseUpdated=$CourseSession->update($data);
        if(!$courseUpdated)
        {
           return new CourseSessionErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseSessionResource($CourseSession);	
       
	}
	public function DeleteCourseSession(CourseSession $CourseSession)
	{
        //dd("fbcbv");		
        $isDelete=$CourseSession->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new CourseSessionErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseSessionResource($CourseSession);		
	}


    public function getNameOfTheDate($date)
    {

        $timestamp = strtotime($date);
        $day = date('l', $timestamp);
        return $day;
    }
    public function AddListOfDays(CourseSessionAddListOfDaysRequest $request)
    {
      
        $date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $days = $request->input('days');
       // $video_session_ids = [];
        while (strtotime($date) <= strtotime($to_date)) {
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            if (in_array($this->getNameOfTheDate($date), $days)) {
                $data= [
                            "start_date" => $date,
                            "start_time" => $request->input("from_time"),
                            "end_time" => $request->input("to_time"),
                            "name" => $request->input("name"),
                            "users_id" => $request->input("user_id"),
                            "courses_id" => $request->input("course_id"),
                ];
                $CourseSessionResponse = CourseSession::create($data);
                
            }
        }
        if(!$CourseSessionResponse)
        {
           return new CourseSessionErrorResource("not found to AddListOfDays.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseSessionResource($CourseSessionResponse);	       
        
    }

    public function CourseSessionData($request)
    {
        $data=[
            'users_id' => $request->user_id,
			'courses_id' => $request->course_id,
			'name' => $request->name,
			'start_date' => $request->start_date,
			'start_time' => $request->start_time,			
			'end_time' => $request->end_time,
			//'course' => $request->course,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
   
 
}
