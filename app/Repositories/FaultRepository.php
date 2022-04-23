<?php namespace App\Repositories;
use App\Http\Requests\FaultCreateRequest;
use App\Http\Requests\FaultEditRequest;
use App\Http\Resources\FaultResource;
use App\Http\Resources\FaultErrorResource;
 
use App\Models\Fault;
use App\Repositories\Interfaces\FaultRepositoryInterface as FaultRepositoryInter;
 
class FaultRepository implements FaultRepositoryInter
{
	public function getAll(){		
		return  FaultResource::collection(Fault::all());
	}
 
	public function getFault($id){
		
		$data=Fault::find($id);        
		if(isset($data))
			return new FaultResource($data);
		else 
        {           
            return new FaultErrorResource("not found to fetch.");
        }
		
	}

	public function addFault(FaultCreateRequest $request){
			
			$data=self::faultData($request);
			$response= Fault::create($data);
			return new FaultResource($response);       
	}
	public function updateFault(FaultEditRequest $request,Fault $fault){
		
		$data=self::faultData($request);		 
	    $faultUpdated=$fault->update($data);
        if(!$faultUpdated)
        {
           return new FaultErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new FaultResource($fault);	
       
	}
	public function deleteFault(Fault $fault){
		$isDelete=$fault->delete();       
        if(!$isDelete)
        {
           return new FaultErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new FaultResource($fault);		
	}
	// public function RestoreFault(Fault $fault){
	// 	//return Fault::create($fault->all());
	// 	return $fault->restore();
	// }
	// more 
	public function faultData($request)
    {
        $data=[
			'description' => $request->description,
		   ];		  
		return 	$data;
    }
 
}

?>