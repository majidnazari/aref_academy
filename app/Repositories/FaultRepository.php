<?php 
namespace App\Repositories;
 
use App\Models\Fault;
use App\Repositories;
 
class FaultRepository implements FaultRepositoryInterface
{
	public function getAll(){
		return Fault::all();
	}
 
	public function getPost($id){
		return Fault::findOrFail($id);
	}
 
	// more 
 
}

?>