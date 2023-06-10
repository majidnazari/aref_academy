<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GateCreateRequest;
use App\Http\Requests\GateEditRequest;
use App\Models\Gate;
use App\Repositories\GateRepository as GateRepo;
use App\Http\Resources\GateErrorResource;



class GateController extends Controller
{
    private $repository;
    public function __construct(GateRepo $repository)
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
        $data = $this->repository->getGate($id);
        return response()->json($data, 200);
    }
    public function store(GateCreateRequest $request)
    {

        $data = $this->repository->addGate($request);
        return response()->json($data, 200);
    }
    public function update(GateEditRequest $request, $id)
    {
        $gate = Gate::find($id);
        if ($gate === null) {
            return new GateErrorResource("not found to update.");
        } else {
            $data = $this->repository->updateGate($request, $gate);
            return response()->json($data, 200);
        }
    }

    public function destroy($id)
    {
        $user = Gate::find($id);
        if (isset($user)) {
            $data = $this->repository->deleteGate($user);
            return response()->json($data, 200);
        } else
            return response()->json(new GateErrorResource("not found to delete"), 404);
    }
}
