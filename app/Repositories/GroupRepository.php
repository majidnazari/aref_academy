<?php

namespace App\Repositories;

use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupEditRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupErrorResource;

use App\Models\Group;
use App\Repositories\Interfaces\GroupRepositoryInterface as GroupRepositoryInter;

class GroupRepository implements GroupRepositoryInter
{
	public function getAll()
	{

		return  GroupResource::collection(Group::all());
	}

	public function getGroup($id)
	{

		$data = Group::find($id);
		if (isset($data))
			return new GroupResource($data);
		else {
			return new GroupErrorResource("not found to fetch.");
		}
	}

	public function addGroup(GroupCreateRequest $request)
	{

		$data = self::groupData($request);
		$response = Group::create($data);
		return new GroupResource($response);
	}
	public function updateGroup(GroupEditRequest $request, Group $group)
	{

		$data = self::groupData($request);
		$groupUpdated = $group->update($data);
		if (!$groupUpdated) {
			return new GroupErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new GroupResource($group);
	}
	public function deleteGroup(Group $group)
	{
		$isDelete = $group->delete();
		if (!$isDelete) {
			return new GroupErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new GroupResource($group);
	}
	public function groupData($request)
	{
		$data = [
			'user_id' => $request->user_id,
			'name' => $request->name,
		];
		return 	$data;
	}
}
