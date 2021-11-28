<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseEditRequest;

use App\Models\Course;
 
 Interface  CourseRepositoryInterface{
	
	public function GetAll(); 
	public function GetCourse($id);
	public function AddCourse(CourseCreateRequest $request);
	public function UpdateCourse(CourseEditRequest $request,Course $course);
	public function DeleteCourse(Course $course);
	//public function RestoreCourse(Course $user);
 
	// more
}

?>