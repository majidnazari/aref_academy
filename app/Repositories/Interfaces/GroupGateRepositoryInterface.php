<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\GroupGateCreateRequest;
use App\Http\Requests\GroupGateEditRequest;


use App\Models\GroupGate;
 
 Interface  GroupGateRepositoryInterface{
	
	public function getAll(); 
	public function getGroupGate($id);
	public function addGroupGate(GroupGateCreateRequest $request);
	public function updateGroupGate(GroupGateEditRequest $request,GroupGate $GroupGate);
	public function deleteGroupGate(GroupGate $GroupGate);
	//public function addListOfDays(GroupGateAddListOfDaysRequest $request);
	//public function RestoreCourse(Course $user);
 
	// more
}

?>