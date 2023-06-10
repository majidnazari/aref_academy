<?php

namespace App\BasicFacade;

use App\Models\CourseStudent;
use GraphQL\Error\Error;
use Log;

class UpdateCourseStudentReport
{
    public function test()
    {        
        return "this is create basic method";
    }
    public function updateTotalReport($params){      
        $courseStudent=CourseStudent::find($params->id);
        if(!$courseStudent)
        {
            return Error::createLocatedError('CourseStudentTOTALREPORT-UPDATE-RECORD_NOT_FOUND');
        }
        $courseStudent->total_not_registered += $params->not_registered;
        $courseStudent->total_noAction += $params->noAction;
        $courseStudent->total_dellay60 += $params->dellay60;
        $courseStudent->total_dellay45 += $params->dellay45;
        $courseStudent->total_dellay30 += $params->dellay30;
        $courseStudent->total_dellay15 += $params->dellay15;
        $courseStudent->total_present += $params->present;
        $courseStudent->total_absent += $params->absent;
        $courseStudent->sum_total_present = $courseStudent->total_dellay60+ $courseStudent->total_dellay45+ $courseStudent->total_dellay30 + $courseStudent->total_dellay15 +$courseStudent->total_present;

        $courseStudent->save();

    }
  
}
