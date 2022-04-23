<?php namespace App\Repositories;

use App\Http\Requests\GateCreateRequest;
use App\Http\Requests\GateEditRequest;
use App\Http\Resources\GateResource;
use App\Http\Resources\GateErrorResource;
 
use App\Models\Gate;
use App\Repositories\Interfaces\GateRepositoryInterface as GateRepositoryInter;
 
class GateRepository implements GateRepositoryInter
{
	public function getAll(){		
		return  GateResource::collection(Gate::all());
	}
 
	public function getGate($id){		
		$data=Gate::find($id);      
		if(isset($data))
			return new GateResource($data);
		else 
        {           
            return new GateErrorResource("not found to fetch.");
        }
	}

	public function addGate(GateCreateRequest $request){
			
			$data=self::gateData($request);
			$response= Gate::create($data);
			return new GateResource($response);       
	}
	public function updateGate(GateEditRequest $request,Gate $gate){		
		
		$data=self::gateData($request);		   
	    $gateUpdated=$gate->update($data);
        if(!$gateUpdated)
        {
           return new GateErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new GateResource($gate);	
       
	}
	public function deleteGate(Gate $gate){
		$isDelete=$gate->delete();
       
        if(!$isDelete)
        {
           return new GateErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new GateResource($gate);		
	}
	// public function RestoreGate(Gate $gate){
	// 	//return Gate::create($gate->all());
	// 	return $gate->restore();
	// }
	// more 
	public function gateData($request)
    {
        $data=[
			'user_id' => $request->user_id,			
			'name' => $request->name,			
			'description' => $request->description,	
		   ];
		return 	$data;
    }
 
}

?>