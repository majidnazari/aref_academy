<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\CourseStudentCreateRequest;
use App\Http\Requests\CourseStudentEditRequest;

use App\Models\CourseStudent;
 
 Interface  CourseStudentRepositoryInterface{
	
	public function getAll(); 
	public function getCourseStudent($id);
	public function addCourseStudent(CourseStudentCreateRequest $request);
	public function updateCourseStudent(CourseStudentEditRequest $request,CourseStudent $coursestudent);
	public function deleteCourseStudent(CourseStudent $coursestudent);
	//public function RestoreCourseStudent(CourseStudent $user);
 
	// more
}

?>