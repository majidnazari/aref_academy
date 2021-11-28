<?php

namespace App\Repositories;
//use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseEditRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseErrorResource;
//use bcrypt; 
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface as userInterface;

//use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CourseRepository.
 */
class CourseRepository  implements userInterface
{
    public function GetAll(){
		//return Course::all();
		return  CourseResource::collection(Course::all());
	}
 
	public function GetCourse($id){
		//return Course::find($id);
		$data=Course::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new CourseResource($data);
		else 
        {           
            return new CourseErrorResource("not found to fetch.");
        }
	}

	public function AddCourse(CourseCreateRequest $request){
       
    //    $data=self::CourseData();
    // $data=[
    //     'name' =>$request->name,
    //     'active' => $request->active,
    //     //'course' => $request->course,			
    //    ];
        $data=self::CourseData($request);
     //dd($data);
       // dd($request->toarray());
       //dd($request->teacher_id);
       $response= Course::create($data);
       return new CourseResource($response);       
	}	

    public function UpdateCourse(CourseEditRequest $request,Course $course){
		//dd("this is user edit");
		//dd($course);
		$data=self::CourseData($request);
		   //dd($request->all());
          // dd($data);
	    $courseUpdated=$course->update($data);
        if(!$courseUpdated)
        {
           return new CourseErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseResource($course);	
       
	}
	public function DeleteCourse(Course $course)
	{
        //dd("fbcbv");		
        $isDelete=$course->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new CourseErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseResource($course);		
	}
    public function CourseData($request)
    {
        $data=[
			'name' => $request->name,
			'type' => $request->type,
			'lesson' => $request->lesson,
			'users_id' => $request->user_id,
			'teachers_id' => $request->teacher_id,
			'years_id' => $request->year_id,
			//'course' => $request->course,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}
