<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteCourseStudent
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
        $CourseStudent=CourseStudent::find($args['id']);

        if(!$CourseStudent)
        {
                return Error::createLocatedError("COURSESTUDENT-DELETE-RECORD_NOT_FOUND");
        }
        $CourseStudent_result= $CourseStudent->delete();        
       
        return $CourseStudent;
        
    }
}
