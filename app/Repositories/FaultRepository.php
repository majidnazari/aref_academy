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

	public function AddFault(FaultCreateRequest $request){
			return Fault::create($request->all());
	}
	public function UpdateFault(FaultCreateRequest $request,Fault $fault){
		//return Fault::create($fault->all());
		return 	$fault->update($request->all());
	}
 
	// more 
 
}

?>