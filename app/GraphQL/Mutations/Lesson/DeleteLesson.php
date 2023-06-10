<?php

namespace App\GraphQL\Mutations\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteLesson
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
        $Lesson=Lesson::find($args['id']);
        if(!$Lesson)
        {
            return Error::createLocatedError('LESSON-DELETE-RECORD_NOT_FOUND');
        }         
       
        $Fault_filled= $Lesson->delete(); 
        return $Lesson;
    }
}
