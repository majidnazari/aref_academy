<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupEditRequest;


use App\Models\Group;
 
 Interface  GroupRepositoryInterface{
	
	public function getAll(); 
	public function getGroup($id);
	public function addGroup(GroupCreateRequest $request);
	public function updateGroup(GroupEditRequest $request,Group $Group);
	public function deleteGroup(Group $Group);	
}

?>