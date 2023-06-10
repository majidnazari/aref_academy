<?php

namespace App\Repositories;

use App\Http\Requests\AzmoonCreateRequest;
use App\Http\Requests\AzmoonEditRequest;
use App\Http\Resources\AzmoonResource;
use App\Http\Resources\AzmoonErrorResource;
use App\Models\Azmoon;
use App\Repositories\Interfaces\AzmoonRepositoryInterface as azmoonInterface;


/**
 * Class AzmoonRepository.
 */
class AzmoonRepository implements azmoonInterface
{
	public function getAll()
	{
		return  AzmoonResource::collection(Azmoon::paginate(env('PAGE_COUNT')));
	}

	public function getAzmoon($id)
	{
		$data = Azmoon::find($id);
		if (isset($data))
			return new AzmoonResource($data);
		else {
			return new AzmoonErrorResource("not found to fetch.");
		}
	}

	public function addAzmoon(AzmoonCreateRequest $request)
	{

		$data = self::azmoonData($request);
		$response = Azmoon::create($data);
		return new AzmoonResource($response);
	}

	public function updateAzmoon(AzmoonEditRequest $request, Azmoon $azmoon)
	{

		$data = self::azmoonData($request);
		$azmoonUpdated = $azmoon->update($data);
		if (!$azmoonUpdated) {
			return new AzmoonErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new AzmoonResource($azmoon);
	}
	public function deleteAzmoon(Azmoon $azmoon)
	{
		$isDelete = $azmoon->delete();
		if (!$isDelete) {
			return new AzmoonErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new AzmoonResource($azmoon);
	}
	public function azmoonData($request)
	{
		$data = [
			'user_id' => $request->user_id,
			'course_id' => $request->course_id,
			'course_session_id' => $request->course_session_id,
			'isSMSsend' => $request->isSMSsend,
			'score' => $request->score,
		];
		return 	$data;
	}
}
