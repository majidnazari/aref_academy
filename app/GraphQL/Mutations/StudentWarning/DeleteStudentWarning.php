<?php

namespace App\GraphQL\Mutations\StudentWarning;

use App\Models\StudentWarning;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class DeleteStudentWarning
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
        $StudentWarning=StudentWarning::find($args['id']);

        if(!$StudentWarning)
        {
                return Error::createLocatedError("STUDENTWARNING-DELETE-RECORD_NOT_FOUND");
        }
        $CourseStudent_result= $StudentWarning->delete();        
       
        return $StudentWarning;
        
    }
}
