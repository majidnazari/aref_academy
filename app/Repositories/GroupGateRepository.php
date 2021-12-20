<?php

namespace App\Repositories;
use App\Http\Requests\GroupGateCreateRequest;
use App\Http\Requests\GroupGateEditRequest;
use App\Http\Resources\GroupGateResource;
use App\Http\Resources\GroupGateErrorResource;
 
use App\Models\GroupGate;
use App\Repositories\Interfaces\GroupGateRepositoryInterface as GroupGateRepositoryInter;
 
class GroupGateRepository implements GroupGateRepositoryInter
{
	public function getAll(){
		//return GroupGate::all();
		return  GroupGateResource::collection(GroupGate::all());
	}
 
	public function getGroupGate($id){
		//return GroupGate::find($id);
		$data=GroupGate::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new GroupGateResource($data);
		else 
        {           
            return new GroupGateErrorResource("not found to fetch.");
        }
		
	}

	public function addGroupGate(GroupGateCreateRequest $request){
       // dd("hit");
			//return GroupGate::create($request->all());
			$data=self::groupGateData($request);
           // dd($data);
			$response= GroupGate::create($data);
			return new GroupGateResource($response);       
	}
	public function updateGroupGate(GroupGateEditRequest $request,GroupGate $groupGate){
		//return GroupGate::create($groupGate->all());
		$data=self::groupGateData($request);
		   //dd($request->all());
           //dd($data);
	    $groupGateUpdated=$groupGate->update($data);
        if(!$groupGateUpdated)
        {
           return new GroupGateErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new GroupGateResource($groupGate);	
       
	}
	public function deleteGroupGate(GroupGate $groupGate){
		$isDelete=$groupGate->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new GroupGateErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new GroupGateResource($groupGate);		
	}
	// public function RestoreGroupGate(GroupGate $groupGate){
	// 	//return GroupGate::create($groupGate->all());
	// 	return $groupGate->restore();
	// }
	// more 
	public function groupGateData($request)
    {
        $data=[
			'user_id' => $request->user_id,			
			'gate_id' => $request->gate_id,			
			'group_id' => $request->group_id,	
			'name' => $request->name,	

		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}