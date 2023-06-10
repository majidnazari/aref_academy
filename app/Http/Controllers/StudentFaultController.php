<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentFaultCreateRequest;
use App\Http\Requests\StudentFaultEditRequest;
use App\Models\StudentFault;
use App\Repositories\StudentFaultRepository as StudentFaultRepo;
use App\Http\Resources\StudentFaultErrorResource;

class StudentFaultController extends Controller
{
    private $repository;
    public function __construct(StudentFaultRepo $repository)
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
        $data = $this->repository->getStudentFault($id);
        return response()->json($data, 200);
    }
    public function store(StudentFaultCreateRequest $request)
    {
        $data = $this->repository->addStudentFault($request);
        return response()->json($data, 200);
    }
    public function update(StudentFaultEditRequest $request, $id)
    {
        $studentcontact = StudentFault::find($id);
        if ($studentcontact === null) {
            return new StudentFaultErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateStudentFault($request, $studentcontact);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $studentcontact = StudentFault::find($id);

        if (isset($studentcontact)) {
            $data = $this->repository->deleteStudentFault($studentcontact);
            return response()->json($data, 200);
        } else
            return response()->json(new StudentFaultErrorResource("not found to delete"), 404);
    }
}
