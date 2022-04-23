<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearEditRequest;

use App\Models\Year;
 
 Interface  YearRepositoryInterface{
	
	public function getAll(); 
	public function getYear($id);
	public function addYear(YearCreateRequest $request);
	public function updateYear(YearEditRequest $request,Year $year);
	public function deleteYear(Year $year);
	//public function RestoreYear(Year $user);
 
	// more
}

?>