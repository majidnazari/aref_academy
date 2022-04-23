<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Repositories\TeacherRepository;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;
use App\Http\Resources\TeacherCollection;
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
        return (new  TeacherCollection($data))->additional([
            'errors' => null,
        ])->response()->setStatusCode(200); 

        return new TeacherCollection($data);  
       //dd($data->content());
       // return(json_decode($data->content()));
        return (new TeacherResource($data))->additional([
            'errors' => null,
        ])->response()->setStatusCode(404);  
        return new TeacherCollection($data);      
        //return response()->json($data,200);
    }
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
       $data=$this->repository->getTeacher($id);
       //return ($data);
       if(!$data)
       {   
            return (new TeacherResource(null))->additional([
                'errors' => ["show teacher" => "there is no teacher to show"],
            ])->response()->setStatusCode(404);  
       }
      
        return (new TeacherResource($data))->additional([
            'errors' => null,
        ])->response()->setStatusCode(200); 

        // return response()->json($data);
        // if($data != null)
        // { 
        //     return (new TeacherResource($data))->additional([
        //         'errors' => null,
        //     ])->response()->setStatusCode(201);  
        // }
        
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
        if(!$data)
        {   
                return (new TeacherResource($data))->additional([
                    'errors' => ["adding teacher" => "there is one more like this"],
                ])->response()->setStatusCode(400);  
        }
      
        return (new TeacherResource($data))->additional([
            'errors' => null,
        ])->response()->setStatusCode(200);        
        //return response()->json($data,200);
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
    public function update(TeacherEditRequest $request, int $teacher_id)
    {
        $data=$this->repository->updateTeacher($request,$teacher_id);
        if(!$data)
        {
            return (new TeacherResource(null))->additional([
                "error" =>["update" => "There is no any teacher with this id"]
            ])->response()->setStatusCode(400);
    
        }
        // if the update theacher be true the request goes to show
        return (new TeacherResource($request))->additional(
            [ "error" => null]
         )->response()->setStatusCode(201);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $teacher_id)
    {
       $data=$this->repository->deleteTeacher($teacher_id);
       if(!$data)
       {
           return (new TeacherResource(null))->additional([
               "error" =>["update" => "There is no any teacher with this id"]
           ])->response()->setStatusCode(400);
   
       }
       // if the update theacher be true the request goes to show
       return (new TeacherResource(null))->additional(
           [ "error" => null]
        )->response()->setStatusCode(201);
       
    }
}
