<?php

namespace App\Repositories;

use App\Http\Requests\YearCreateRequest;
use App\Http\Requests\YearEditRequest;
use App\Http\Resources\YearResource;
use App\Http\Resources\YearErrorResource;
use App\Models\Year;
use App\Repositories\Interfaces\YearRepositoryInterface as userInterface;

/**
 * Class YearRepository.
 */
class YearRepository  implements userInterface
{
	public function getAll()
	{
		return  YearResource::collection(Year::all());
	}

	public function getYear($id)
	{
		$data = Year::find($id);

		if (isset($data))
			return new YearResource($data);
		else {
			return new YearErrorResource("not found to fetch.");
		}
	}

	public function addYear(YearCreateRequest $request)
	{
		$data = self::yearData($request);
		$response = Year::create($data);
		return new YearResource($response);
	}

	public function updateYear(YearEditRequest $request, Year $year)
	{
		$data = self::yearData($request);
		$yearUpdated = $year->update($data);
		if (!$yearUpdated) {
			return new YearErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new YearResource($year);
	}
	public function deleteYear(Year $year)
	{
		$isDelete = $year->delete();

		if (!$isDelete) {
			return new YearErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new YearResource($year);
	}
	public function yearData($request)
	{
		$data = [
			'name' => $request->name,
			'active' => $request->active
		];

		return 	$data;
	}
}
