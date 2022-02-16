<?php

namespace App\Repositories;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;
use App\Http\Resources\AbsencePresenceResource;
use App\Http\Resources\AbsencePresenceCollection;
use App\Http\Resources\AbsencePresenceErrorResource;
//use bcrypt; 
use App\Models\AbsencePresence;
use App\Repositories\Interfaces\AbsencePresenceRepositoryInterface as userInterface;

//use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class AbsencePresenceRepository.
 */
class AbsencePresenceRepository  implements userInterface
{
    public function getAll(){
		$data= AbsencePresence::with("user")->get();
		//return  AbsencePresenceResource::collection(AbsencePresence::with("user"));
		return new  AbsencePresenceCollection ($data);
	}
 
	public function getAbsencePresence($id){
		
		$data=AbsencePresence::where("id",$id)->with("user")->with("courseSession")->first();       
		if(isset($data))
			return new AbsencePresenceResource($data);
		else 
        {           
            return new AbsencePresenceErrorResource("not found to fetch.");
        }
	}

	public function addAbsencePresence(AbsencePresenceCreateRequest $request){       
    
        $data=self::absencePresenceData($request);    
       $response= AbsencePresence::create($data);
       return new AbsencePresenceResource($response);       
	}	

    public function updateAbsencePresence(AbsencePresenceEditRequest $request,AbsencePresence $absencepresence){
		
		$data=self::absencePresenceData($request);		
	    $absencepresenceUpdated=$absencepresence->update($data);
        if(!$absencepresenceUpdated)
        {
           return new AbsencePresenceErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new AbsencePresenceResource($absencepresence);	
       
	}
	public function deleteAbsencePresence(AbsencePresence $absencepresence)	{
       
        $isDelete=$absencepresence->delete();
        
        if(!$isDelete)
        {
           return new AbsencePresenceErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new AbsencePresenceResource($absencepresence);		
	}
    public function absencePresenceData($request)
    {
        $data=[				
			'user_id' => $request->user_id,
			'course_session_id' => $request->course_session_id,
			'teacher_id' => $request->teacher_id,
            'status' => $request->status,
			//'absencepresence' => $request->absencepresence,			
		   ];
		  
		return 	$data;
    }
 
}
