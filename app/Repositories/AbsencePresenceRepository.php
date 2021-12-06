<?php

namespace App\Repositories;
//use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;
use App\Http\Resources\AbsencePresenceResource;
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
    public function GetAll(){
		//return AbsencePresence::all();
		return  AbsencePresenceResource::collection(AbsencePresence::all());
	}
 
	public function GetAbsencePresence($id){
		//return AbsencePresence::find($id);
		$data=AbsencePresence::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new AbsencePresenceResource($data);
		else 
        {           
            return new AbsencePresenceErrorResource("not found to fetch.");
        }
	}

	public function AddAbsencePresence(AbsencePresenceCreateRequest $request){
       
    //    $data=self::AbsencePresenceData();
    // $data=[
    //     'name' =>$request->name,
    //     'active' => $request->active,
    //     //'absencepresence' => $request->absencepresence,			
    //    ];
        $data=self::AbsencePresenceData($request);
     //dd($data);
       // dd($request->toarray());
       //dd($request->teacher_id);
       $response= AbsencePresence::create($data);
       return new AbsencePresenceResource($response);       
	}	

    public function UpdateAbsencePresence(AbsencePresenceEditRequest $request,AbsencePresence $absencepresence){
		//dd("this is user edit");
		//dd($absencepresence);
		$data=self::AbsencePresenceData($request);
		   //dd($request->all());
          // dd($data);
	    $absencepresenceUpdated=$absencepresence->update($data);
        if(!$absencepresenceUpdated)
        {
           return new AbsencePresenceErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new AbsencePresenceResource($absencepresence);	
       
	}
	public function DeleteAbsencePresence(AbsencePresence $absencepresence)
	{
        //dd("fbcbv");		
        $isDelete=$absencepresence->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new AbsencePresenceErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new AbsencePresenceResource($absencepresence);		
	}
    public function AbsencePresenceData($request)
    {
        $data=[				
			'user_id' => $request->user_id,
			'course_sessions_id' => $request->course_session_id,
			'teachers_id' => $request->teacher_id,
            'status' => $request->status,
			//'absencepresence' => $request->absencepresence,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}
