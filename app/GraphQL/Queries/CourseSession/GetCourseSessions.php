<?php

namespace App\GraphQL\Queries\CourseSession;

use App\Models\Course;
use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use AuthRole;
use Carbon\Carbon;
use Log;

final class GetCourseSessions
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveCourseSession($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        if (AuthRole::CheckAccessibility("CourseSession")) {
            return CourseSession::where('deleted_at', null) //;//->orderBy('id','desc');
                ->whereHas('course', function ($query) use ($branch_id) {
                    if ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    }
                    return true;
                })->with('course');
        }
        $CourseSession = CourseSession::where('deleted_at', null)
            ->where('id', -1);
        return  $CourseSession;
    }

    function resolveCourseReportAtSpecialTimeSortedByDate($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       
        if (!AuthRole::CheckAccessibility("CourseReportAtSpecialTimeSortedByDate")) {
            return [];
        }

       // Log::info("start date is:".$args['session_date_from'] . " and end date is:". $args['session_date_to']);
        $branch_id = auth()->guard('api')->user()->branch_id;
        $courseSession = CourseSession::where('start_date','>=',$args['session_date_from'])
        ->where('start_date','<=',$args['session_date_to'])
        ->with('course')
        ->orderBy('start_date', 'asc')
        // ->whereHas('courseSession',function($queryWhere) use($args){
        //     $queryWhere->where('start_date','>',$args['session_date_from']);
        //     //->where('start_date','<=',$args['session_date_to']);
        // })
        // ->with(['courseSession' => function($queryWith) use($args){
        //     $queryWith->where('start_date','>=',$args['session_date_from'])
        //     ->where('start_date','<=',$args['session_date_to'])
        //     ->orderBy('start_date', 'asc');
        // }])
        ->get();
        //return $courseSessions;
           
                $data = [];
                $index = 0;
                $tempDate = Carbon::create($args['session_date_from']);
                $finishDate = Carbon::create($args['session_date_to']);
                while (($tempDate <= $finishDate) && ($index < 7)) {
                    $data[] = [
                        "date" => $tempDate->copy(),
                        "details" => $this->getDateData($courseSession, $tempDate)
                    ];
                    $tempDate=$tempDate->addDays(1);
                    $index++;
                }
                return $data; 

   
    }

    function getDateData($courseSessions, Carbon $session_date_from)
    {        
        return $courseSessions
            ->where('start_date', $session_date_from->format('Y-m-d'))
            //->sortBy('start_time')
            ->map(function (CourseSession $singlerecord) {
                return [
                    "id" => $singlerecord->id,
                    "start_date" => $singlerecord->start_date,
                    "start_time" => $singlerecord->start_time,
                    "end_time" => $singlerecord->end_time, 
                    
                    "course" =>   $courseSessions->course,                 
                ];
            });
    }
}
