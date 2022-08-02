<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;
use Log;

final class GetCourseStudentsWithIllegalStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (AuthRole::CheckAccessibility("GetCourseStudentsWithIllegalStudent")) {
            $qu = DB::table('course_students As CS')
                ->select(
                    'CS.id as id',
                    'CS.financial_status as financial_status',
                    'AB.status as status',
                    'CS.student_id as student_id',
                    'Cse.name',
                    'Cse.course_id'
                )
                ->where('CS.financial_status', '!=', 'approved')
                ->leftjoin('course_sessions AS Cse', function ($query) {
                    $query->on('Cse.course_id', 'CS.course_id');
                })
                ->leftjoin('absence_presences AS AB', function ($query) use ($args) {
                    $query->on('AB.student_id', 'CS.student_id')
                        ->on('AB.course_session_id', 'Cse.id')
                        ->where('AB.status', 'present');
                });
            $result = $qu->get();
            $result = $result->where('status', '!=', null)->groupBy(['course_id', 'student_id']);
            $output = collect([]);
            foreach ($result as $courseDetails) {
                foreach ($courseDetails as $details) {
                    $detail = $details[0];
                    $detail->session_count = count($details);
                    $output[] = $detail;
                }
            }
            $output = $output->where('session_count', '>=', 2);
            return $output;
        }
        return  [];
    }
}
