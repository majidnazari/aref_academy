<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseStudentCreateRequest;
use App\Http\Requests\CourseStudentEditRequest;
use App\Repositories\CourseStudentRepository as CourseStudentRepo;
use App\Http\Resources\CourseStudentErrorResource;
use App\Http\Resources\CourseStudentResource;

use App\Models\CourseStudent;

class CourseStudentController extends Controller
{
    private $repository;
    public function __construct(CourseStudentRepo $repository)
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
        $data = $this->repository->getCourseStudent($id);
        return response()->json($data, 200);
    }
    public function store(CourseStudentCreateRequest $request)
    {
        $data = $this->repository->addCourseStudent($request);
        return response()->json($data, 200);
    }
    public function update(CourseStudentEditRequest $request, $id)
    {
        $coursestudent = CourseStudent::find($id);
        if ($coursestudent === null) {
            return new CourseStudentErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateCourseStudent($request, $coursestudent);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $coursestudent = CourseStudent::find($id);

        if (isset($coursestudent)) {
            $data = $this->repository->deleteCourseStudent($coursestudent);
            return response()->json($data, 200);
        } else
            return response()->json(new CourseStudentErrorResource("not found to delete"), 404);
    }
}
