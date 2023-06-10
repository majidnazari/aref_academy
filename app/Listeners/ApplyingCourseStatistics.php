<?php

namespace App\Listeners;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use Carbon\Carbon;

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

        $current_date = Carbon::now()->format('Y-m-d');
        $current_time = Carbon::now()->format('H:i:s');

        $numberofcoursesessionpassed = CourseSession::where('course_id', $event->params['course_id'])
            ->where('isCancel', false)
            ->where(function ($q) use ($current_date, $current_time) {
                $q->where('start_date', '<', $current_date)
                    ->orWhere(function ($query) use ($current_date, $current_time) {
                        $query->where('start_date', '=', $current_date)
                            ->where('end_time', '<', $current_time);
                    });
            })
            ->count('id');
        $totalSession = CourseSession::where('course_id', $event->params['course_id'])->where('isCancel', false)->count('id');
        $courseStudents = CourseStudent::where('course_id', $event->params['course_id'])
            //->where('student_id',$event->params['student_id'])
            ->get();
        if (!$courseStudents) {
            return false;
        }

        foreach ($courseStudents as $courseStudent) {
            $sum_not_registered += $courseStudent->total_not_registered;
            $sum_noAction += $courseStudent->total_noAction;
            $sum_dellay60 += $courseStudent->total_dellay60;
            $sum_dellay45 += $courseStudent->total_dellay45;
            $sum_dellay30 += $courseStudent->total_dellay30;
            $sum_dellay15 += $courseStudent->total_dellay15;
            $sum_present += $courseStudent->total_present;
            $sum_absent += $courseStudent->total_absent;
        }
        $course = Course::where('id', $event->params['course_id'])->first();
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

        $course->save();
    }
}
