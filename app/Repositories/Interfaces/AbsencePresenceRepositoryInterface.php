<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;

use App\Models\AbsencePresence;
 
 Interface  AbsencePresenceRepositoryInterface{
	
	public function GetAll(); 
	public function GetAbsencePresence($id);
	public function AddAbsencePresence(AbsencePresenceCreateRequest $request);
	public function UpdateAbsencePresence(AbsencePresenceEditRequest $request,AbsencePresence $absencepresence);
	public function DeleteAbsencePresence(AbsencePresence $absencepresence);
	//public function RestoreAbsencePresence(AbsencePresence $user);
 
	// more
}

?>