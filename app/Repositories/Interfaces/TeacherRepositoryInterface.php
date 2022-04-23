<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;

 
 Interface  TeacherRepositoryInterface{
	
	public function getAll(); 
	public function getTeacher($id);
	public function addTeacher(TeacherCreateRequest $request);
	public function updateTeacher(TeacherEditRequest $request,int $id);
	public function deleteTeacher(int $id);
	
}

?>