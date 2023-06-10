<?php

namespace App\Repositories;

use App\Http\Requests\AbsencePresenceCreateRequest;
use App\Http\Requests\AbsencePresenceEditRequest;
use App\Http\Resources\AbsencePresenceResource;
use App\Http\Resources\AbsencePresenceCollection;
use App\Http\Resources\AbsencePresenceErrorResource;
use App\Models\AbsencePresence;
use App\Repositories\Interfaces\AbsencePresenceRepositoryInterface as userInterface;

/**
 * Class AbsencePresenceRepository.
 */
class AbsencePresenceRepository  implements userInterface
{
	public function getAll()
	{
		$absencepresence = AbsencePresence::with("user")->paginate(env('PAGE_COUNT'));
		return $absencepresence;
	}

	public function getAbsencePresence($id)
	{

		$data = AbsencePresence::where("id", $id)->with("user")->with("courseSession")->first();
		return $data;
	}

	public function addAbsencePresence(AbsencePresenceCreateRequest $request)
	{

		$data = $this->absencePresenceData($request);
		$response = AbsencePresence::create($data);
		return $response;
	}

	public function updateAbsencePresence(AbsencePresenceEditRequest $request, AbsencePresence $absencepresence)
	{

		$data = self::absencePresenceData($request);
		$absencepresenceUpdated = $absencepresence->update($data);
		if (!$absencepresenceUpdated) {
			return new AbsencePresenceErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new AbsencePresenceResource($absencepresence);
	}
	public function deleteAbsencePresence(AbsencePresence $absencepresence)
	{

		$isDelete = $absencepresence->delete();

		if (!$isDelete) {
			return new AbsencePresenceErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new AbsencePresenceResource($absencepresence);
	}
	public function absencePresenceData($request)
	{
		$data = [
			'user_id' => $request->user_id,
			'course_session_id' => $request->course_session_id,
			'teacher_id' => $request->teacher_id,
			'status' => $request->status,
		];

		return 	$data;
	}
}
