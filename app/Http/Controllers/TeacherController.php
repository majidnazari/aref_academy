<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Repositories\TeacherRepository;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;
use App\Http\Resources\TeacherCollectionResource;
use App\Http\Resources\TeacherResource;

class TeacherController extends Controller
{
    public $repository;
    function __construct(TeacherRepository $repository)
    {
        $this->repository=$repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data=$this->repository->getAll(); 
       //dd($data->content());
        return(json_decode($data->content()));
       // return new TeacherCollectionResource($data);      
        //return response()->json($data,200);
    }
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {       
        $data=$this->repository->getTeacher($teacher);
       if(!$data)
       {   
            dd("false");
        }
       dd("true");
        return (new TeacherResource($data))->additional([
            'errors' => null,
        ])->response()->setStatusCode(201); 

        return response()->json($data);
        if($data != null)
        { 
            return (new TeacherResource($data))->additional([
                'errors' => null,
            ])->response()->setStatusCode(201);  
        }
         return (new TeacherResource($data))->additional([
            'errors' => ["show teacher" => "there is no teacher to show"],
        ])->response()->setStatusCode(201);  
        //return ($data);
        
        //return new TeacherResource($data);
        //return response()->json($data,200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherCreateRequest $request)
    {
        $data=$this->repository->addTeacher($request);
        dd($data);
        return response()->json($data,200);
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(teacher $teacher)
    {
        //
    }
}
