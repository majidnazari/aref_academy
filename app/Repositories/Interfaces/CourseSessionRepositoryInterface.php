<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionEditRequest;
use App\Http\Requests\CourseSessionAddListOfDaysRequest;

use App\Models\CourseSession;
 
 Interface  CourseSessionRepositoryInterface{
	
	public function getAll(); 
	public function getCourseSession($id);
	public function addCourseSession(CourseSessionCreateRequest $request);
	public function updateCourseSession(CourseSessionEditRequest $request,CourseSession $CourseSession);
	public function deleteCourseSession(CourseSession $CourseSession);
	public function addListOfDays(CourseSessionAddListOfDaysRequest $request);
	
}
