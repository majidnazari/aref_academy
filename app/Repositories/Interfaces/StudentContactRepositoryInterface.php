<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\StudentContactCreateRequest;
use App\Http\Requests\StudentContactEditRequest;


use App\Models\StudentContact;
 
 Interface  StudentContactRepositoryInterface{
	
	public function getAll(); 
	public function getStudentContact($id);
	public function addStudentContact(StudentContactCreateRequest $request);
	public function updateStudentContact(StudentContactEditRequest $request,StudentContact $StudentContact);
	public function deleteStudentContact(StudentContact $StudentContact);
	//public function addListOfDays(StudentContactAddListOfDaysRequest $request);
	//public function RestoreCourse(Course $user);
 
	// more
}

?>