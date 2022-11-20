<?php

namespace App\Listeners;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use Carbon\Carbon;
use GraphQL\Error\Error;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class ApplyingCourseStatistics
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UpdateCourseStudentStatistics $event)
    {
        $sum_not_registered = 0;
        $sum_noAction = 0;
        $sum_dellay60 = 0;
        $sum_dellay45 = 0;
        $sum_dellay30 = 0;
        $sum_dellay15 = 0;
        $sum_present = 0;
        $sum_absent = 0;
        $totalSession = 0;
        // $total_noMoney = 0;
        // $total_withMoney = 0;
        // $total_transferred = 0;

        //Log::info("new listener is:".$event->params['course_id']);
        //return false;
        $current_date = Carbon::now()->format('Y-m-d');
        $current_time = Carbon::now()->format('H:i:s');
        //Log::info("current date is: " . $current_date . " current time is" . $current_time);

        $numberofcoursesessionpassed = CourseSession::where('course_id', $event->params['course_id'])
            ->where(function ($q) use ($current_date, $current_time) {
                $q->where('start_date', '<', $current_date)
                    ->orWhere(function ($query) use ($current_date, $current_time) {
                        $query->where('start_date', '=', $current_date)
                            ->where('end_time', '<', $current_time);
                    });
            })
            ->count('id');
        $totalSession = CourseSession::where('course_id', $event->params['course_id'])->count('id');
        //Log::info("the count of passed session is:" .$numberofcoursesessionpassed );   
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_not_registered');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_noAction');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_dellay60');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_dellay45');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_dellay30');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_dellay15');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_present');
        //   $sum_not_registerred= CourseStudent::where('course_id',$event->params['course_id'])->sum('total_absent');

        $courseStudents = CourseStudent::where('course_id', $event->params['course_id'])
            //->where('student_id',$event->params['student_id'])
            ->get();
        if (!$courseStudents) {
            return false;
        }
        // $sum_not_registered += $courseStudent->total_not_registered;
        // $sum_noAction = $courseStudent->total_noAction;
        // $sum_dellay60 = $courseStudent->total_dellay60;
        // $sum_dellay45 = $courseStudent->total_dellay45;
        // $sum_dellay30 = $courseStudent->total_dellay30;
        // $sum_dellay15 = $courseStudent->total_dellay15;
        // $sum_present = $courseStudent->total_present;
        // $sum_absent = $courseStudent->total_absent;


        foreach ($courseStudents as $courseStudent) {
            $sum_not_registered += $courseStudent->total_not_registered;
            $sum_noAction += $courseStudent->total_noAction;
            $sum_dellay60 += $courseStudent->total_dellay60;
            $sum_dellay45 += $courseStudent->total_dellay45;
            $sum_dellay30 += $courseStudent->total_dellay30;
            $sum_dellay15 += $courseStudent->total_dellay15;
            $sum_present += $courseStudent->total_present;
            $sum_absent += $courseStudent->total_absent;
            // $total_withMoney += $courseStudent->financial_refused_status == "withMoney"  ? 1 : 0;
            // $total_noMoney += $courseStudent->financial_refused_status == "noMoney"  ? 1 : 0;
            // $total_transferred += $courseStudent->transferred_to_course_id == ""  ? 1 : 0;
        }
        $course = Course::where('id', $event->params['course_id'])->first();
        //Log::info("divition is: " . $sum_present / $numberofcoursesessionpassed);
        $course->sum_not_registered_session = $sum_not_registered; // $numberofcoursesessionpassed;
        $course->sum_noAction_session = $sum_noAction; // $numberofcoursesessionpassed;
        $course->sum_dellay60_session = $sum_dellay60; // $numberofcoursesessionpassed;
        $course->sum_dellay45_session = $sum_dellay45; // $numberofcoursesessionpassed;
        $course->sum_dellay30_session = $sum_dellay30; // $numberofcoursesessionpassed;
        $course->sum_dellay15_session = $sum_dellay15; // $numberofcoursesessionpassed;
        $course->sum_present_session = $sum_present; // $numberofcoursesessionpassed;
        $course->sum_absent_session = $sum_absent; // $numberofcoursesessionpassed;
        $course->total_session = $totalSession;
        $course->total_done_session = $numberofcoursesessionpassed;
        $course->total_remain_session = $totalSession - $numberofcoursesessionpassed;
        // $course->total_transferred=$total_transferred;
        // $course->total_noMoney=$total_noMoney;
        // $course->total_withMoney=$total_withMoney;


        $course->save();
        //->sum('total_not_registered');
        //    ->sum('total_noAction')
        //    ->sum('total_dellay60')
        //    ->sum('total_dellay45')
        //    ->sum('total_dellay30')
        //    ->sum('total_dellay15')
        //    ->sum('total_present')
        //    ->sum('total_absent');
        //Log::info("all sum are:\n" . $all_course_session_ids_of_this_course);
    }
}
