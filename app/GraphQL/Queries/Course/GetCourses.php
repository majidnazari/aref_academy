<?php

namespace App\GraphQL\Queries\Course;

use App\Models\Course;
use App\Models\Year;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use AuthRole;
use Log;


final class GetCourses
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function resolveCourse($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;


        $active_years_id = Year::where('active', true)->pluck('id');
        //Log::info("year id is:". json_encode($active_years_id));
        //Log::info("args year id is:" .  $active_years_id);

        if (AuthRole::CheckAccessibility("Course")) {
            $course = Course::where('deleted_at', null) //->orderBy('id','desc');
                ->where(function ($query) use ($branch_id) {
                    if ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    }
                })
                ->whereIn('year_id',  $active_years_id)
                //$course->whereIn('branch_id', $branch_id)
                ->whereHas('lesson', function ($query) use ($args) {
                    if (isset($args['lesson_name']))
                        $query->where('lessons.name', 'LIKE', '%' . $args['lesson_name'] . '%');
                    else
                        return true;
                })
                ->with(['lesson' => function ($query) use ($args) {
                    if (isset($args['lesson_name']))
                        $query->where('lessons.name', 'LIKE', '%' . $args['lesson_name'] . '%');
                    else
                        return true;
                }]);

            return $course;
        }
        return Course::where('deleted_at', null)
            ->where('id', -1);
    }
    function resolveCourseTotalReport($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("CourseTotalReport")) {
            $courses_tmp = (isset($args['course_id'])  && ($args['course_id'] != -1)) ? Course::where('id', $args['course_id'])->whereIn('branch_id', $branch_id)->with('teacher')->get() : Course::whereIn('branch_id', $branch_id)->with('teacher')->orderBy('id', 'asc')->get();
            $data = [];
            $courses = [];
            $absence_presence_id = 0;
            $start_session = "";
            $end_session = "";
            foreach ($courses_tmp as $course) {
                $teache_name = $course->teacher->first_name . ' ' . $course->teacher->last_name;
                $courseSession = CourseSession::where('course_id', $course->id)
                    ->orderBy('start_date', 'asc');
                $courseSession_last = CourseSession::where('course_id', $course->id)->orderBy('start_date', 'desc');
                $all_dellay_sum = $course->sum_dellay60_session + $course->sum_dellay45_session + $course->sum_dellay30_session + $course->sum_dellay30_session + $course->sum_dellay15_session;
                $courses = [
                    "id" => $course->id,
                    "teacher_name" => $teache_name,
                    "start_session" => $courseSession->exists() ?  $courseSession->first()->start_date : "",
                    "end_session" => $courseSession_last->exists() ? $courseSession_last->first()->start_date : "",
                    "total_session" => $course->total_session,
                    "total_done_session" => $course->total_done_session,

                    "avg_absent" => (!empty($course->sum_absent_session)) ? ($course->sum_absent_session / $course->total_done_session) : null,
                    "avg_dellay" => (!empty($all_dellay_sum)) ? ($all_dellay_sum / $course->total_done_session) : null,
                    "total_students" => CourseStudent::where('course_id', $course->id)->count('id'),
                    "total_approved" => CourseStudent::where('course_id', $course->id)->where('student_status', 'ok')->where('manager_status', 'approved')->where('financial_status', 'approved')->count('id'),
                    "total_noMoney" => CourseStudent::where('course_id', $course->id)
                        ->where('student_status', 'ok')
                        ->where('manager_status', 'approved')
                        ->where('financial_status', 'pending')
                        ->count('id'),
                    "total_noMoney_semi_pending"  => CourseStudent::where('course_id', $course->id)
                        ->where('student_status', 'ok')
                        ->where('manager_status', 'approved')
                        ->where('financial_status', 'semi_approved')
                        ->count('id'),
                    "total_pending" => CourseStudent::where('course_id', $course->id)
                        ->where('student_status', 'ok')
                        ->where('manager_status', 'pending')
                        ->where('financial_status', 'pending')
                        ->count('id'),
                    "total_refused" => CourseStudent::where('course_id', $course->id)
                        ->where('student_status', 'refused')
                        ->count(),
                    "total_fired" => CourseStudent::where('course_id', $course->id)
                        ->where('student_status', "fired")
                        ->count(),
                    "total_just_noMoney" => CourseStudent::where('course_id', $course->id)
                        ->where('financial_refused_status', "noMoney")
                        ->count(),
                    "total_just_returned" => CourseStudent::where('course_id', $course->id)
                        ->where('financial_refused_status', "returned")
                        ->count(),
                    "total_just_not_returned" => CourseStudent::where('course_id', $course->id)
                        ->where('financial_refused_status', "not_returned")
                        ->count(),
                    "total_transferred" => CourseStudent::where('course_id', $course->id)->where('transferred_to_course_id', '!=', null)->count(),
                ];
                $data[] = $courses;
            }

            return $data;
        }
        return Course::where('deleted_at', null)
            ->where('id', -1);
    }

    function resolveCourseReportAtSpecialTime($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $data = [];
        $courses = [];
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        $courseSessionFilterFunction = function ($query) use ($args) {
            if (isset($args['course_date_from'])) {
                $query->where('course_sessions.start_date', '>=', $args['course_date_from']);
            }
            if (isset($args['course_date_to'])) {
                $query->where('course_sessions.start_date', '<=', $args['course_date_to']);
            }
        };

        if (AuthRole::CheckAccessibility("CourseReportAtSpecialTime")) {
            $selectedCourses = Course::where('deleted_at', null)
                ->whereIn('branch_id', $branch_id)
                ->whereHas('courseSession', $courseSessionFilterFunction)
                ->with(['courseSession' => $courseSessionFilterFunction]);


            return $selectedCourses;
        }
        return Course::where('deleted_at', null)
            ->where('id', -1);
    }
}
