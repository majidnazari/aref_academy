<?php

namespace App\Repositories;
use App\Http\Requests\StudentFaultCreateRequest;
use App\Http\Requests\StudentFaultEditRequest;
use App\Http\Resources\StudentFaultResource;
use App\Http\Resources\StudentFaultErrorResource;
 
use App\Models\StudentFault;
use App\Repositories\Interfaces\StudentFaultRepositoryInterface as StudentFaultRepositoryInter;
 
class StudentFaultRepository implements StudentFaultRepositoryInter
{
	public function getAll(){
		//return StudentFault::all();
		return  StudentFaultResource::collection(StudentFault::all());
	}
 
	public function getStudentFault($id){
		//return StudentFault::find($id);
		$data=StudentFault::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new StudentFaultResource($data);
		else 
        {           
            return new StudentFaultErrorResource("not found to fetch.");
        }
		
	}

	public function addStudentFault(StudentFaultCreateRequest $request){
        //dd("hit");
			//return StudentFault::create($request->all());
			$data=self::studentfaultData($request);

			$response= StudentFault::create($data);
			return new StudentFaultResource($response);       
	}
	public function updateStudentFault(StudentFaultEditRequest $request,StudentFault $studentfault){
		//return StudentFault::create($studentfault->all());
		$data=self::studentfaultData($request);
		   //dd($request->all());
           //dd($data);
	    $studentfaultUpdated=$studentfault->update($data);
        if(!$studentfaultUpdated)
        {
           return new StudentFaultErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new StudentFaultResource($studentfault);	
       
	}
	public function deleteStudentFault(StudentFault $studentfault){
		$isDelete=$studentfault->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new StudentFaultErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new StudentFaultResource($studentfault);		
	}
	// public function RestoreStudentFault(StudentFault $studentfault){
	// 	//return StudentFault::create($studentfault->all());
	// 	return $studentfault->restore();
	// }
	// more 
	public function studentfaultData($request)
    {
        $data=[
			'user_id' => $request->user_id,			
			'student_id' => $request->student_id,			
			'fault_id' => $request->fault_id,	
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}