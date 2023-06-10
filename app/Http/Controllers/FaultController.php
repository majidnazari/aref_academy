<?php
//namespace Repositories;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaultCreateRequest;
use App\Http\Requests\FaultEditRequest;
use App\Models\Fault;
use App\Repositories\FaultRepository as FaultRepo;
use App\Http\Resources\FaultErrorResource;

class FaultController extends Controller
{

    private $repository;
    public function __construct(FaultRepo $repository)
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
        $data = $this->repository->getFault($id);
        return response()->json($data, 200);
    }

    public function store(FaultCreateRequest $request)
    {
        $data = $this->repository->addFault($request);
        return response()->json($data, 200);
    }
    public function update(FaultEditRequest $request, Fault $fault)
    {
        $data = $this->repository->updateFault($request, $fault);
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $fault = Fault::find($id);
        if (isset($fault)) {
            $data = $this->repository->deleteFault($fault);
            return response()->json($data, 200);
        } else
            return response()->json(new FaultErrorResource("not found to delete"), 404);
    }
    public function restore($id)
    {
        $fault = Fault::withTrashed()->find($id);

        if (isset($fault)) {
            $data = $this->repository->restoreFault($fault);
            return response()->json($data, 200);
        } else
            return response()->json(false, 404);
    }
}
