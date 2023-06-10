<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentEditRequest;

 
 Interface  StudentRepositoryInterface{
	
	public function getAll(); 
	public function getStudent($id);
	public function addStudent(StudentCreateRequest $request);
	public function updateStudent(StudentEditRequest $request,int $id);
	public function deleteStudent(int $id);	
}

?>