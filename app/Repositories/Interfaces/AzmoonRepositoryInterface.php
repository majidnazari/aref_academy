<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\AzmoonCreateRequest;
use App\Http\Requests\AzmoonEditRequest;

use App\Models\Azmoon;
 
 Interface  AzmoonRepositoryInterface{
	
	public function getAll(); 
	public function getAzmoon($id);
	public function addAzmoon(AzmoonCreateRequest $request);
	public function updateAzmoon(AzmoonEditRequest $request,Azmoon $azmoon);
	public function deleteAzmoon(Azmoon $azmoon);
	//public function RestoreAzmoon(Azmoon $user);
 
	// more
}

?>