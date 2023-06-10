<?php

namespace App\Repositories;

use App\Http\Requests\GroupGateCreateRequest;
use App\Http\Requests\GroupGateEditRequest;
use App\Http\Resources\GroupGateResource;
use App\Http\Resources\GroupGateErrorResource;

use App\Models\GroupGate;
use App\Repositories\Interfaces\GroupGateRepositoryInterface as GroupGateRepositoryInter;

class GroupGateRepository implements GroupGateRepositoryInter
{
	public function getAll()
	{
		return  GroupGateResource::collection(GroupGate::all());
	}

	public function getGroupGate($id)
	{

		$data = GroupGate::find($id);
		if (isset($data))
			return new GroupGateResource($data);
		else {
			return new GroupGateErrorResource("not found to fetch.");
		}
	}

	public function addGroupGate(GroupGateCreateRequest $request)
	{

		$data = self::groupGateData($request);
		$response = GroupGate::create($data);
		return new GroupGateResource($response);
	}
	public function updateGroupGate(GroupGateEditRequest $request, GroupGate $groupGate)
	{

		$data = self::groupGateData($request);
		$groupGateUpdated = $groupGate->update($data);
		if (!$groupGateUpdated) {
			return new GroupGateErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new GroupGateResource($groupGate);
	}
	public function deleteGroupGate(GroupGate $groupGate)
	{
		$isDelete = $groupGate->delete();
		if (!$isDelete) {
			return new GroupGateErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new GroupGateResource($groupGate);
	}
	public function groupGateData($request)
	{
		$data = [
			'user_id' => $request->user_id,
			'gate_id' => $request->gate_id,
			'group_id' => $request->group_id,
			'user_id_created' => $request->user_id_created,

		];
		return 	$data;
	}
}
