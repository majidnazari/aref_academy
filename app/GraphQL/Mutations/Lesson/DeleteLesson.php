<?php

namespace App\GraphQL\Mutations\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
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
        //$args["user_id_creator"]=$user_id;
        $Lesson=Lesson::find($args['id']);
        if(!$Lesson)
        {
            return Error::createLocatedError('LESSON-DELETE-RECORD_NOT_FOUND');
        }         
       
        $Fault_filled= $Lesson->delete(); 
        return $Lesson;
    }
}
