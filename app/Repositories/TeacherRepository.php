<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;
use App\Models\Teacher;
use App\Http\Resources\TeacherCollectionResource;
use App\Http\Resources\TeacherErrorResource;
use App\Http\Resources\TeacherResource;
//use Your Model
use App\Repositories\Interfaces\TeacherRepositoryInterface as TeacheRepo;

/**
 * Class TeacherRepositoryInterface.
 */
class TeacherRepository implements TeacheRepo
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public function getAll()
    {
       $teachers= Teacher::paginate(env('PAGE_COUNT'));
      // return new  TeacherCollectionresource($teachers);
       return response()->json($teachers,200);
    }   
	public function getTeacher($id)
    {       
        $teacher=Teacher::find($id);
        if(!$teacher)
        {
            //dd("false");
            return null;
        }
        return $teacher;
       // return new TeacherResource($teacher);
        //return response()->json($teacher,200);
    }
	public function addTeacher(TeacherCreateRequest $request)
    {

        $teacher=Teacher::create($request->all());
        return new TeacherResource($teacher);
    }
	public function updateTeacher(TeacherEditRequest $request,int $id)
    {

    }
	public function deleteTeacher(int $id)
    {

    }
}
