<?php

namespace App\Listeners;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseStudent;
use GraphQL\Error\Error;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class ApplyingCourseStudentStatistics
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
       // Log::info("the __construct of listerer  is running\n");
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdateCourseStudentStatistics  $event
     * @return void
     */
    public function handle(UpdateCourseStudentStatistics $event)
    {
        //Log::info("the listener handle is running and params is :\n" . json_encode($event->params));
        $courseStudent=CourseStudent::where('course_id',$event->params['course_id'])
        ->where('student_id',$event->params['student_id'])->first();
        if(!$courseStudent)
        {
            return Error::createLocatedError('1CourseStudentTOTALREPORT-UPDATE-RECORD_NOT_FOUND');
        }

        //Log::info("the course student is :\n" . $courseStudent['total_not_registered']);

        $courseStudent['total_not_registered'] += $event->params['total_not_registered'];
        $courseStudent['total_noAction']+=$event->params['total_noAction'];
        $courseStudent['total_dellay60']+=$event->params['total_dellay60'];
        $courseStudent['total_dellay45']+=$event->params['total_dellay45'];
        $courseStudent['total_dellay30']+=$event->params['total_dellay30'];
        $courseStudent['total_dellay15']+=$event->params['total_dellay15'];
        $courseStudent['total_present']+=$event->params['total_present'];
        $courseStudent['total_absent']+=$event->params['total_absent'];

        $courseStudent->save();

        //Log::info("the listener handle is running and params is :\n" . $event->params['course_id']);

    }
   
}
