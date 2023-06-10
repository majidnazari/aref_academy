<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseEditRequest;
use App\Models\Course;
use App\Repositories\CourseRepository as CourseRepo;
use App\Http\Resources\CourseErrorResource;

class CourseController extends Controller
{
    private $repository;
    public function __construct(CourseRepo $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $data = $this->repository->getAll();
        return response()->json($data, 200);
    }
    public function show($id)
    {
        $data = $this->repository->getCourse($id);
        return response()->json($data, 200);
    }
    public function store(CourseCreateRequest $request)
    {

        $data = $this->repository->addCourse($request);
        return response()->json($data, 200);
    }
    public function update(CourseEditRequest $request, $id)
    {
        $course = Course::find($id);
        if ($course === null) {
            return new CourseErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateCourse($request, $course);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $user = Course::find($id);
        if (isset($user)) {
            $data = $this->repository->deleteCourse($user);
            return response()->json($data, 200);
        } else
            return response()->json(new CourseErrorResource("not found to delete"), 404);
    }
}
