<?php

namespace App\Repositories;

use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseEditRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseErrorResource;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface as userInterface;


/**
 * Class CourseRepository.
 */
class CourseRepository  implements userInterface
{
	public function getAll()
	{

		return  CourseResource::collection(Course::all());
	}

	public function getCourse($id)
	{

		$data = Course::find($id);
		if (isset($data))
			return new CourseResource($data);
		else {
			return new CourseErrorResource("not found to fetch.");
		}
	}

	public function addCourse(CourseCreateRequest $request)
	{

		$data = self::courseData($request);
		$response = Course::create($data);
		return new CourseResource($response);
	}

	public function updateCourse(CourseEditRequest $request, Course $course)
	{

		$data = self::courseData($request);
		$courseUpdated = $course->update($data);
		if (!$courseUpdated) {
			return new CourseErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
		}
		return new CourseResource($course);
	}
	public function deleteCourse(Course $course)
	{

		$isDelete = $course->delete();
		if (!$isDelete) {
			return new CourseErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
		}
		return new CourseResource($course);
	}
	public function courseData($request)
	{
		$data = [
			'name' => $request->name,
			'type' => $request->type,
			'lesson' => $request->lesson,
			'user_id' => $request->user_id,
			'teacher_id' => $request->teacher_id,
			'year_id' => $request->year_id,
		];

		return 	$data;
	}
}
