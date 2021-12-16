<?php

namespace App\Repositories;

use App\Http\Requests\CourseStudentCreateRequest;
use App\Http\Requests\CourseStudentEditRequest;
use App\Http\Resources\CourseStudentResource;
use App\Http\Resources\CourseStudentErrorResource;
//use bcrypt; 
use App\Models\CourseStudent;
use App\Repositories\Interfaces\CourseStudentRepositoryInterface as coursestudentInterface;
//use Your Model

/**
 * Class CourseStudentStudentRepository.
 */
class CourseStudentRepository implements coursestudentInterface
{
        public function getAll(){
            //return CourseStudent::all();
            return  CourseStudentResource::collection(CourseStudent::all());
        }
     
        public function getCourseStudent($id){
            //return CourseStudent::find($id);
            $data=CourseStudent::find($id);
            //dd($data);
            //return $data;
            if(isset($data))
                return new CourseStudentResource($data);
            else 
            {           
                return new CourseStudentErrorResource("not found to fetch.");
            }
        }
    
        public function addCourseStudent(CourseStudentCreateRequest $request){
           
        //    $data=self::CourseStudentData();
        // $data=[
        //     'name' =>$request->name,
        //     'active' => $request->active,
        //     //'courseStudent' => $request->courseStudent,			
        //    ];
            $data=self::courseStudentData($request);
         //dd($data);
           // dd($request->toarray());
          // dd($data);
           $response= CourseStudent::create($data);
           return new CourseStudentResource($response);       
        }	
    
        public function updateCourseStudent(CourseStudentEditRequest $request,CourseStudent $courseStudent){
            //dd("this is user edit");
            //dd($courseStudent);
            $data=self::courseStudentData($request);
               //dd($request->all());
              // dd($data);
            $courseStudentUpdated=$courseStudent->update($data);
            if(!$courseStudentUpdated)
            {
               return new CourseStudentErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
            }
            return new CourseStudentResource($courseStudent);	
           
        }
        public function deleteCourseStudent(CourseStudent $courseStudent)
        {
            //dd("fbcbv");		
            $isDelete=$courseStudent->delete();
            //dd("ff");
            if(!$isDelete)
            {
               return new CourseStudentErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
            }
            return new CourseStudentResource($courseStudent);		
        }
        public function courseStudentData($request)
        {
            $data=[
                'course_id' => $request->course_id,
                'student_id' => $request->student_id,
                'status' => $request->status,
                'user_id_created' => $request->user_id_created,
                'user_id_approved' => $request->user_id_approved,                			
               ];
               //dd($request->all());
            return 	$data;
        }
     
    
}
