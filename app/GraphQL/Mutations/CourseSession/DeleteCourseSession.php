<?php

namespace App\GraphQL\Mutations\CourseSession;

use App\Models\AbsencePresence;
use App\Models\CourseSession;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class DeleteCourseSession
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $current_date=Carbon::now()->format('Y-m-d');
        $current_time=Carbon::now()->format('H:i:s');
        $error_msg="";
        
        $user_id = auth()->guard('api')->user()->id;
        $args["user_id_creator"] = $user_id;
        $CourseSession = CourseSession::find($args['id']);
      

        if (!$CourseSession) {
            return Error::createLocatedError("COURSESESSION-DELETE-RECORD_NOT_FOUND");
        }       

        $empty_absence_presence = AbsencePresence::where('course_session_id', $CourseSession->id)
        ->where(function($query)  {
            $query->whereNotIn('status',['not_registered', 'noAction']);            
          
        })
        ->WhereHas('courseSession',function($q) use ($current_date, $current_time) {
            $q->where('start_date','<',$current_date )
            ->orWhere(function($query) use($current_date,$current_time){
                $query->where('start_date','=',$current_date)
                ->where('end_time','<',$current_time);
            }) ;
        })
        ->with('courseSession')
        ->count();
        if ($empty_absence_presence > 0) {

            return Error::createLocatedError("COURSESESSION-DELETE-IT_IS_USED_BEFORE");
        }
       
        $CourseSession_result= $CourseSession->delete();        

        return $CourseSession;
    }
}
