<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupGateCreateRequest;
use App\Http\Requests\GroupGateEditRequest;
use App\Models\GroupGate;
use App\Repositories\GroupGateRepository as GroupGateRepo;
use App\Http\Resources\GroupGateErrorResource;

class GroupGateController extends Controller
{
    private $repository;
    public function __construct(GroupGateRepo $repository)
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
        $data = $this->repository->getGroupGate($id);
        return response()->json($data, 200);
    }
    public function store(GroupGateCreateRequest $request)
    {

        $data = $this->repository->addGroupGate($request);
        return response()->json($data, 200);
    }
    public function update(GroupGateEditRequest $request, $id)
    {
        $GroupGate = GroupGate::find($id);
        if ($GroupGate === null) {
            return new GroupGateErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateGroupGate($request, $GroupGate);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $GroupGate = GroupGate::find($id);
        if (isset($GroupGate)) {
            $data = $this->repository->deleteGroupGate($GroupGate);
            return response()->json($data, 200);
        } else
            return response()->json(new GroupGateErrorResource("not found to delete"), 404);
    }
}
