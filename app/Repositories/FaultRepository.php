<?php namespace App\Repositories;
use App\Http\Requests\FaultCreateRequest;
use App\Http\Resources\FaultResource;
 
use App\Models\Fault;
use App\Repositories\Interfaces\FaultRepositoryInterface as FaultRepositoryInter;
 
class FaultRepository implements FaultRepositoryInter
{
	public function GetAll(){
		//return Fault::all();
		return  FaultResource::collection(Fault::all());
	}
 
	public function GetFault($id){
		//return Fault::find($id);
		$data=Fault::find($id);
		//return $data;
		if(isset($data))
			return new FaultResource($data);
		else 
			return ("not found");
		
	}

	public function AddFault(FaultCreateRequest $request){
			return Fault::create($request->all());
	}
	public function UpdateFault(FaultCreateRequest $request,Fault $fault){
		//return Fault::create($fault->all());
		return 	$fault->update($request->all());
	}
	public function DeleteFault(Fault $fault){
		//return Fault::create($fault->all());
		return 	$fault->delete();
	}
	public function RestoreFault(Fault $fault){
		//return Fault::create($fault->all());
		return $fault->restore();
	}
	// more 
 
}

?>