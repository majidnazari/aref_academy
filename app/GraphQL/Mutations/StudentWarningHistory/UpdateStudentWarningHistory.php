<?php

namespace App\GraphQL\Mutations\StudentWarningHistory;

use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

final class UpdateStudentWarningHistory
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
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id_updater"]=$user_id;
        $student_warning=StudentWarning::where('student_id',$args['student_warning_student_id'])->first();
       // Log::info("history is: " . $student_warning->student_warning_history_id);
        //return $student_warning;
        $student_warning_history=StudentWarningHistory::where('id',$student_warning->student_warning_history_id)->first();
        //return $student_warning_history;
        
        if(!$student_warning_history)
        {
            return Error::createLocatedError("STUDENTWARNINGHISTORY-UPDATE-RECORD_NOT_FOUND");
        }
        
        $student_warning_history_filled= $student_warning_history->fill($args);
        $student_warning_history->save(); 
        $student_warning->delete();      
       
        return $student_warning_history;

        
    }
}
