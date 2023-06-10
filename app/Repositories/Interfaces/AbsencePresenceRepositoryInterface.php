<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;

use App\Models\AbsencePresence;
 
 Interface  AbsencePresenceRepositoryInterface{
	
	public function getAll(); 
	public function getAbsencePresence($id);
	public function addAbsencePresence(AbsencePresenceCreateRequest $request);
	public function updateAbsencePresence(AbsencePresenceEditRequest $request,AbsencePresence $absencepresence);
	public function deleteAbsencePresence(AbsencePresence $absencepresence);	
}
