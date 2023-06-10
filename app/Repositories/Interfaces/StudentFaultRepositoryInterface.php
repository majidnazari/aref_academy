<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\StudentFaultCreateRequest;
use App\Http\Requests\StudentFaultEditRequest;


use App\Models\StudentFault;
 
 Interface  StudentFaultRepositoryInterface{
	
	public function getAll(); 
	public function getStudentFault($id);
	public function addStudentFault(StudentFaultCreateRequest $request);
	public function updateStudentFault(StudentFaultEditRequest $request,StudentFault $StudentFault);
	public function deleteStudentFault(StudentFault $StudentFault);	
}

?>