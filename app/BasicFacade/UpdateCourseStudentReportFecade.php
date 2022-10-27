<?php

namespace App\BasicFacade;

use App\Models\CourseStudent;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Facade;

use Log;

class UpdateCourseStudentReportFecade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'UpdateCourseStudentReport';
    }
  
}
