<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\GateCreateRequest;
use App\Http\Requests\GateEditRequest;

use App\Models\Gate;
 
 Interface  GateRepositoryInterface{
	
	public function GetAll(); 
	public function GetGate($id);
	public function AddGate(GateCreateRequest $request);
	public function UpdateGate(GateEditRequest $request,Gate $year);
	public function DeleteGate(Gate $year);
	//public function RestoreGate(Gate $user);
 
	// more
}

?>