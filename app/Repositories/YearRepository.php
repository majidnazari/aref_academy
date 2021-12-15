<?php

namespace App\Repositories;
//use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearEditRequest;
use App\Http\Resources\YearResource;
use App\Http\Resources\YearErrorResource;
//use bcrypt; 
use App\Models\Year;
use App\Repositories\Interfaces\YearRepositoryInterface as userInterface;

//use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class YearRepository.
 */
class YearRepository  implements userInterface
{
    public function getAll(){
		//return Year::all();
		return  YearResource::collection(Year::all());
	}
 
	public function getYear($id){
		//return Year::find($id);
		$data=Year::find($id);
        //dd($data);
		//return $data;
		if(isset($data))
			return new YearResource($data);
		else 
        {           
            return new YearErrorResource("not found to fetch.");
        }
	}

	public function addYear(YearCreateRequest $request){
       
    //    $data=self::YearData();
    // $data=[
    //     'name' =>$request->name,
    //     'active' => $request->active,
    //     //'year' => $request->year,			
    //    ];
        $data=self::yearData($request);
       $response= Year::create($data);
       return new YearResource($response);       
	}	

    public function updateYear(YearEditRequest $request,Year $year){
		//dd("this is user edit");
		//dd($year);
		$data=self::yearData($request);
		   //dd($request->all());
          // dd($data);
	    $yearUpdated=$year->update($data);
        if(!$yearUpdated)
        {
           return new YearErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
		return new YearResource($year);	
       
	}
	public function deleteYear(Year $year)
	{
        //dd("fbcbv");		
        $isDelete=$year->delete();
        //dd("ff");
        if(!$isDelete)
        {
           return new YearErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
		return new YearResource($year);		
	}
    public function yearData($request)
    {
        $data=[
			'name' => $request->name,
			'active' => $request->active
			//'year' => $request->year,			
		   ];
		   //dd($request->all());
		return 	$data;
    }
 
}
