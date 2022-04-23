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
           
            return  CourseStudentResource::collection(CourseStudent::all());
        }
     
        public function getCourseStudent($id){
           
            $data=CourseStudent::find($id);            
            if(isset($data))
                return new CourseStudentResource($data);
            else 
            {           
                return new CourseStudentErrorResource("not found to fetch.");
            }
        }
    
        public function addCourseStudent(CourseStudentCreateRequest $request){
        
            $data=self::courseStudentData($request);        
           $response= CourseStudent::create($data);
           return new CourseStudentResource($response);       
        }	
    
        public function updateCourseStudent(CourseStudentEditRequest $request,CourseStudent $courseStudent){
           
            $data=self::courseStudentData($request);
            $courseStudentUpdated=$courseStudent->update($data);
            if(!$courseStudentUpdated)
            {
               return new CourseStudentErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
            }
            return new CourseStudentResource($courseStudent);	
           
        }
        public function deleteCourseStudent(CourseStudent $courseStudent)
        {           	
            $isDelete=$courseStudent->delete();           
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
            return 	$data;
        }
     
    
}
