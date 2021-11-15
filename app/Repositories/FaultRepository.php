<?php namespace App\Repositories;
use App\Http\Requests\FaultCreateRequest;
 
use App\Models\Fault;
use App\Repositories\Interfaces\FaultRepositoryInterface as FaultRepositoryInter;
 
class FaultRepository implements FaultRepositoryInter
{
	public function GetAll(){
		return Fault::all();
	}
 
	public function GetFault($id){
		return Fault::findOrFail($id);
	}

	public function AddFault(FaultCreateRequest $fault){
			return Fault::Create($fault);
	}
 
	// more 
 
}

?>