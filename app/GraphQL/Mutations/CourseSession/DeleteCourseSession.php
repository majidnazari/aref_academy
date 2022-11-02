<?php

namespace App\GraphQL\Mutations\CourseSession;

use App\Models\AbsencePresence;
use App\Models\CourseSession;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
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
      
        //Log::info("the find is:" . ($CourseSession));

        if (!$CourseSession) {
            return Error::createLocatedError("COURSESESSION-DELETE-RECORD_NOT_FOUND");
        }
        // $empty_absence_presence = AbsencePresence::where('course_session_id', $CourseSession->id)
        // ->where(function($query)  {
        //     $query->whereNotIn('status',['not_registered', 'noAction']);
            
        //     //->orWhere('status', '!=', 'noAction');
        // })->count();

        $empty_absence_presence = AbsencePresence::where('course_session_id', $CourseSession->id)
        ->where(function($query)  {
            $query->whereNotIn('status',['not_registered', 'noAction']);
            
            //->orWhere('status', '!=', 'noAction');
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

        // ->where(function ($q) use ($current_date, $current_time) {
        //     $q->where('start_date','<',$current_date )
        //     ->orWhere(function($query) use($current_date,$current_time){
        //         $query->where('start_date','=',$current_date)
        //         ->where('end_time','<',$current_time);
        //     }) ;
        // });      

        // $all_course_session_ids_of_this_course = CourseSession::
        // where('course_id', $course_id)
        // ->where(function ($q) use ($current_date, $current_time) {
        //     $q->where('start_date','<',$current_date )
        //     ->orWhere(function($query) use($current_date,$current_time){
        //         $query->where('start_date','=',$current_date)
        //         ->where('end_time','<',$current_time);
        //     }) ;
        // })      
        // ->pluck('id');
           
           
        //Log::info("the count of all except  not_R and noA is:" . $empty_absence_presence);
        if ($empty_absence_presence > 0) {

            return Error::createLocatedError("COURSESESSION-DELETE-IT_IS_USED_BEFORE");
        }
        // if(!$CourseSession)
        // {
        //     return [
        //         'status'  => 'Error',
        //         'message' => __('cannot delete CourseSession'),
        //     ];
        // }
        $CourseSession_result= $CourseSession->delete();        

        return $CourseSession;
    }
}
