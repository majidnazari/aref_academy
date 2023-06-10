<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\GateCreateRequest;
use App\Http\Requests\GateEditRequest;

use App\Models\Gate;
 
 Interface  GateRepositoryInterface{
	
	public function getAll(); 
	public function getGate($id);
	public function addGate(GateCreateRequest $request);
	public function updateGate(GateEditRequest $request,Gate $gate);
	public function deleteGate(Gate $gate);	
}
