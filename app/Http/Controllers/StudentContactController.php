<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentContactCreateRequest;
use App\Http\Requests\StudentContactEditRequest;
use App\Models\StudentContact;
use App\Repositories\StudentContactRepository as StudentContactRepo;
use App\Http\Resources\StudentContactErrorResource;

class StudentContactController extends Controller
{
    private $repository;
    public function __construct(StudentContactRepo $repository)
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
        $data = $this->repository->getStudentContact($id);
        return response()->json($data, 200);
    }
    public function store(StudentContactCreateRequest $request)
    {
        $data = $this->repository->addStudentContact($request);
        return response()->json($data, 200);
    }
    public function update(StudentContactEditRequest $request, $id)
    {
        $studentcontact = StudentContact::find($id);
        if ($studentcontact === null) {
            return new StudentContactErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateStudentContact($request, $studentcontact);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $studentcontact = StudentContact::find($id);
        if (isset($studentcontact)) {

            $data = $this->repository->deleteStudentContact($studentcontact);
            return response()->json($data, 200);
        } else
            return response()->json(new StudentContactErrorResource("not found to delete"), 404);
    }
}
