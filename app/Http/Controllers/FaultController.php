<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fault;

class FaultController extends Controller
{
    //

    public function index()
    {
        $data=Fault::all();
        return response()->json($data,200);
    }
}
