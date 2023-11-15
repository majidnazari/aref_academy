<?php

namespace App\GraphQL\Mutations\Course;

use App\Models\Course;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateCourse
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
        $course=Course::find($args['id']);
        
        if(!$course)
        {
            return Error::createLocatedError("COURSE-UPDATE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروزرسانی دوره:رکورد مورد نظر یافت نشد.");
        }
        $course_filled= $course->fill($args);
        $course->save();       
       
        return $course;

        
    }
}
