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
        $total_not_registered = 0;
        $total_noAction = 0;
        $total_dellay60 = 0;
        $total_dellay45 = 0;
        $total_dellay30 = 0;
        $total_dellay15 = 0;
        $total_present = 0;
        $total_absent = 0;
       // Log::info("the listener handle is running and params is :\n" . json_encode($event->params));
        $courseStudent=CourseStudent::where('course_id',$event->params['course_id'])
        ->where('student_id',$event->params['student_id'])->first();
        if(!$courseStudent)
        {
            return false;// Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND');
        }
        
        $all_absencePresence_of_a_course_of_student=AbsencePresence::where('student_id',$event->params['student_id'])
        ->whereHas('courseSession.course',function($query) use($event){
            $query->where('id',$event->params['course_id']);
        })
        ->with('courseSession.course')
        ->get();
        foreach($all_absencePresence_of_a_course_of_student  as $one_absence_presence)
        {
                //Log::info("the isds are:" . $one_absence_presence->id );
                $total_not_registered += $one_absence_presence->status=="not_registered" ? 1:0 ;
                $total_noAction += $one_absence_presence->status=="noAction" ? 1:0 ;
                $total_dellay60 += $one_absence_presence->status=="dellay60" ? 1:0 ;
                $total_dellay45 += $one_absence_presence->status=="dellay45" ? 1:0 ;
                $total_dellay30 += $one_absence_presence->status=="dellay30" ? 1:0 ;
                $total_dellay15 += $one_absence_presence->status=="dellay15" ? 1:0 ;
                $total_present += $one_absence_presence->status=="present" ? 1:0 ;
                $total_absent += $one_absence_presence->status=="absent" ? 1:0 ;
        } 
        //return false;      

        //Log::info("the course student is :\n" . $courseStudent['total_not_registered']);

        $courseStudent['total_not_registered'] =$total_not_registered;
        $courseStudent['total_noAction']=$total_noAction;
        $courseStudent['total_dellay60']=$total_dellay60;
        $courseStudent['total_dellay45']=$total_dellay45;
        $courseStudent['total_dellay30']=$total_dellay30;
        $courseStudent['total_dellay15']=$total_dellay15;
        $courseStudent['total_present']=$total_present;
        $courseStudent['total_absent']=$total_absent;

        $courseStudent->save();

        //Log::info("the listener handle is running and params is :\n" . $event->params['course_id']);

    }
   
}
