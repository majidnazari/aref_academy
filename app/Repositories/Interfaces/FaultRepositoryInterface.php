<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\FaultCreateRequest;
use App\Http\Requests\FaultEditRequest;

use App\Models\Fault;
 
 Interface  FaultRepositoryInterface{
	
	public function getAll(); 
	public function getFault($id);
	public function addFault(FaultCreateRequest $request);
	public function updateFault(FaultEditRequest $request,Fault $fault);
	public function deleteFault(Fault $fault);
	//public function RestoreFault(Fault $fault);
 
	// more
}

?>