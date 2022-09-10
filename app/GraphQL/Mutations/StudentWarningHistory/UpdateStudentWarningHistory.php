<?php

namespace App\GraphQL\Mutations\StudentWarningHistory;

use App\Models\StudentWarningHistory;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


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
        $args["user_id_creator"]=$user_id;
        $course=StudentWarningHistory::find($args['id']);
        
        if(!$course)
        {
            return Error::createLocatedError("STUDENTWARNINGHISTORY-UPDATE-RECORD_NOT_FOUND");
        }
        $course_filled= $course->fill($args);
        $course->save();       
       
        return $course;

        
    }
}
