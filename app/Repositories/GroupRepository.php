<?php

namespace App\Repositories;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupEditRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupErrorResource;
 
use App\Models\Group;
use App\Repositories\Interfaces\GroupRepositoryInterface as GroupRepositoryInter;
 
class GroupRepository implements GroupRepositoryInter
{
	public function getAll(){
		//return Group::all();
		return  GroupResource::collection(Group::all());
	}
 
	public function getGroup($id){
		//return Group::find($id);
		$data=Group::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new GroupResource($data);
		else 
        {           
            return new GroupErrorResource("not found to fetch.");
        }
		
	}

	public function addGroup(GroupCreateRequest $request){
        //dd("hit");
			//return Group::create($request->all());
			$data=self::groupData($request);
        //dd($data);
			$response= Group::create($data);
			return new GroupResource($response);       
	}
	public function updateGroup(GroupEditRequest $request,Group $group){
		//return Group::create($group->all());
		$data=self::groupData($request);
		   //dd($request->all());
           //dd($data);
	    $groupUpdated=$group->update($data);
        if(!$groupUpdated)
        {
           return new GroupErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new GroupResource($group);	
       
	}
	public function deleteGroup(Group $group){
		$isDelete=$group->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new GroupErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new GroupResource($group);		
	}
	// public function RestoreGroup(Group $group){
	// 	//return Group::create($group->all());
	// 	return $group->restore();
	// }
	// more 
	public function groupData($request)
    {
        $data=[
			'user_id' => $request->user_id,			
			'name' => $request->name,
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}