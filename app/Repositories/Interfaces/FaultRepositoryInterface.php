<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\FaultCreateRequest;

use App\Models\Fault;
 
 Interface  FaultRepositoryInterface{
	
	public function GetAll();
 
	public function GetFault($id);

	public function AddFault(FaultCreateRequest $fault);
 
	// more
}

?>