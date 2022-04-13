<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;
use App\Models\Teacher;
use App\Http\Resources\TeacherCollectionResource;
use App\Http\Resources\TeacherErrorResource;
use App\Http\Resources\TeacherResource;
use Illuminate\Http\Request;
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
       return $teachers;
      // return new  TeacherCollectionresource($teachers);
       return response()->json($teachers,200);
    }   
	public function getTeacher($id)
    {     
        $teacher=Teacher::find($id);      
       // $result= $teacher !== null ?  $teacher:  null;
        return $teacher;
       
       // return new TeacherResource($teacher);
        //return response()->json($teacher,200);
    }
	public function addTeacher(TeacherCreateRequest $request)
    {       
        $teacher=Teacher::create($request->all());
        return $teacher;
        //return new TeacherResource($teacher);
    }
	public function updateTeacher(TeacherEditRequest $request,int $id)
    {       
        $teacher=Teacher::find($id);
        if(!$teacher)
        {
            return $teacher;
            // return (new TeacherResource(null))->addintional([
            //     "error" => ["Update Teacher" => "there is problem to update teacher"]
            // ])->response()->setStatusCode(400);
        }

       $updateResult=$teacher->update($this->teacherData($request)); //return true if the update was successfull
       
       //dd( $updateResult);
       return $updateResult;


    }
	public function deleteTeacher(int $teacher_id)
    {
        $teacher=Teacher::find($teacher_id);  // if not found any teacher return null
       
        if(!$teacher)
        {
            return $teacher;            
        }
        return $teacher->delete();// if delete successfully it return back true
    }

    public function teacherData(Request $request)
    {
        $data=[
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "mobile" => $request->mobile,
            "address" => $request->address,
            "user_id" => $request->user_id

        ];

        return $data;
    }
}
