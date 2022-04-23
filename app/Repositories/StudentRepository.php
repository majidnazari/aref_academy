<?php

namespace App\Repositories;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentEditRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentErrorResource;
use App\Http\Resources\StudentCollectionResource;

use App\Http\Utils\StudentUtility;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\StudentRepositoryInterface as StudentRepositoryInter;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class StudentRepository.
 */
class StudentRepository implements StudentRepositoryInter
{
    public function getAll(){	
        
        $studentUtility= new StudentUtility();
        $students=$studentUtility->getAllStudents();
        return new StudentCollectionResource($students);
		
	}
    public function getStudent($id){	
       
        $studentUtility= new StudentUtility();
        $student=$studentUtility->getStudent($id);
        return new  StudentResource($student);
		
	}
    public function addStudent(Request $request){	
       
        $studentUtility= new StudentUtility();
        $student=$studentUtility->addStudent($request);
        return new  StudentResource($student);
		
	}
    public function updateStudent(Request $request,int $id){	
       
        $studentUtility= new StudentUtility();
        $student=$studentUtility->updateStudent($request,$id);
        return new  StudentResource($student);
		
	}
    public function deleteStudent($id){	
       
        $studentUtility= new StudentUtility();
        $student=$studentUtility->deleteStudent($id);
        return ($student);
		
	}
    
    
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }
}
