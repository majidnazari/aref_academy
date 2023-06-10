<?php

namespace App\Repositories;

use App\Http\Requests\TeacherCreateRequest;
use App\Http\Requests\TeacherEditRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
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
        $teachers = Teacher::paginate(env('PAGE_COUNT'));
        return $teachers;
    }
    public function getTeacher($id)
    {
        $teacher = Teacher::find($id);
        return $teacher;
    }
    public function addTeacher(TeacherCreateRequest $request)
    {
        $teacher = Teacher::create($this->teacherData($request)/*$request->all()*/);
        return $teacher;
    }
    public function updateTeacher(TeacherEditRequest $request, int $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return $teacher;
        }

        $updateResult = $teacher->update($this->teacherData($request)); //return true if the update was successfull       
        return $updateResult;
    }
    public function deleteTeacher(int $teacher_id)
    {
        $teacher = Teacher::find($teacher_id);  // if not found any teacher return null       
        if (!$teacher) {
            return $teacher;
        }
        return $teacher->delete(); // if delete successfully it return back true
    }

    public function teacherData(Request $request)
    {
        $data = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "mobile" => $request->mobile,
            "address" => $request->address,
            "user_id" => $request->user_id
        ];
        return $data;
    }
}
