<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseEditRequest;

use App\Models\Course;
 
 Interface  CourseRepositoryInterface{
	
	public function getAll(); 
	public function getCourse($id);
	public function addCourse(CourseCreateRequest $request);
	public function updateCourse(CourseEditRequest $request,Course $course);
	public function deleteCourse(Course $course);	
}
