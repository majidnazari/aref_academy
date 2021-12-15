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
    public function getAll(){
		//return Course::all();
		return  CourseResource::collection(Course::all());
	}
 
	public function getCourse($id){
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

	public function addCourse(CourseCreateRequest $request){
       
    //    $data=self::CourseData();
    // $data=[
    //     'name' =>$request->name,
    //     'active' => $request->active,
    //     //'course' => $request->course,			
    //    ];
        $data=self::courseData($request);
     //dd($data);
       // dd($request->toarray());
       //dd($request->teacher_id);
       $response= Course::create($data);
       return new CourseResource($response);       
	}	

    public function updateCourse(CourseEditRequest $request,Course $course){
		//dd("this is user edit");
		//dd($course);
		$data=self::courseData($request);
		   //dd($request->all());
          // dd($data);
	    $courseUpdated=$course->update($data);
        if(!$courseUpdated)
        {
           return new CourseErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new CourseResource($course);	
       
	}
	public function deleteCourse(Course $course)
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
    public function courseData($request)
    {
        $data=[
			'name' => $request->name,
			'type' => $request->type,
			'lesson' => $request->lesson,
			'user_id' => $request->user_id,
			'teacher_id' => $request->teacher_id,
			'year_id' => $request->year_id,
			//'course' => $request->course,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}
