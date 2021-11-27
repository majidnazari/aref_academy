<?php namespace App\Repositories\Interfaces;
use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearEditRequest;

use App\Models\Year;
 
 Interface  YearRepositoryInterface{
	
	public function GetAll(); 
	public function GetYear($id);
	public function AddYear(YearCreateRequest $request);
	public function UpdateYear(YearEditRequest $request,Year $year);
	public function DeleteYear(Year $year);
	//public function RestoreYear(Year $user);
 
	// more
}

?>