<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionEditRequest;
use App\Http\Requests\CourseSessionAddListOfDaysRequest;

use App\Models\CourseSession;
 
 Interface  CourseSessionRepositoryInterface{
	
	public function GetAll(); 
	public function GetCourseSession($id);
	public function AddCourseSession(CourseSessionCreateRequest $request);
	public function UpdateCourseSession(CourseSessionEditRequest $request,CourseSession $CourseSession);
	public function DeleteCourseSession(CourseSession $CourseSession);
	public function AddListOfDays(CourseSessionAddListOfDaysRequest $request);
	//public function RestoreCourse(Course $user);
 
	// more
}

?>