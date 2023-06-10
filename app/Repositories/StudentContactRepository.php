<?php

namespace App\Repositories;

use App\Http\Requests\StudentContactCreateRequest;
use App\Http\Requests\StudentContactEditRequest;
use App\Http\Resources\StudentContactResource;
use App\Http\Resources\StudentContactErrorResource;

use App\Models\StudentContact;
use App\Repositories\Interfaces\StudentContactRepositoryInterface as StudentContactRepositoryInter;

class StudentContactRepository implements StudentContactRepositoryInter
{
	public function getAll()
	{

		return  StudentContactResource::collection(StudentContact::all());
	}

	public function getStudentContact($id)
	{

		$data = StudentContact::find($id);
		if (isset($data))
			return new StudentContactResource($data);
		else {
			return new StudentContactErrorResource("not found to fetch.");
		}
	}

	public function addStudentContact(StudentContactCreateRequest $request)
	{

		$data = self::studentcontactData($request);
		$response = StudentContact::create($data);
		return new StudentContactResource($response);
	}
	public function updateStudentContact(StudentContactEditRequest $request, StudentContact $studentcontact)
	{

		$data = self::studentcontactData($request);
		$studentcontactUpdated = $studentcontact->update($data);
		if (!$studentcontactUpdated) {
			return new StudentContactErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new StudentContactResource($studentcontact);
	}
	public function deleteStudentContact(StudentContact $studentcontact)
	{
		$isDelete = $studentcontact->delete();
		if (!$isDelete) {
			return new StudentContactErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new StudentContactResource($studentcontact);
	}
	public function studentcontactData($request)
	{
		$data = [
			'user_id' => $request->user_id,
			'student_id' => $request->student_id,
			'absence_presence_id' => $request->absence_presence_id,
			'who_answered' => $request->who_answered,
			'description' => $request->description,
			'is_called_successfull' => $request->is_called_successfull,
		];

		return 	$data;
	}
}
