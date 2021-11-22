<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\FaultCreateRequest;

use App\Models\Fault;
 
 Interface  FaultRepositoryInterface{
	
	public function GetAll(); 
	public function GetFault($id);
	public function AddFault(FaultCreateRequest $request);
	public function UpdateFault(FaultEditRequest $request,Fault $fault);
	public function DeleteFault(Fault $fault);
	public function RestoreFault(Fault $fault);
 
	// more
}

?>