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
		//return Gate::all();
		return  GateResource::collection(Gate::all());
	}
 
	public function getGate($id){
		//return Gate::find($id);
		$data=Gate::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new GateResource($data);
		else 
        {           
            return new GateErrorResource("not found to fetch.");
        }
		
	}

	public function addGate(GateCreateRequest $request){
			//return Gate::create($request->all());
			$data=self::gateData($request);

			$response= Gate::create($data);
			return new GateResource($response);       
	}
	public function updateGate(GateEditRequest $request,Gate $gate){
		//return Gate::create($gate->all());
		$data=self::gateData($request);
		   //dd($request->all());
           //dd($data);
	    $gateUpdated=$gate->update($data);
        if(!$gateUpdated)
        {
           return new GateErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new GateResource($gate);	
       
	}
	public function deleteGate(Gate $gate){
		$isDelete=$gate->delete();
        //dd("ff");
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
			//'course' => $request->course,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}

?>