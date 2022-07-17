<?php

namespace App\GraphQL\Mutations\CourseSession;

use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateCourseSession
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
        $CourseSession=CourseSession::find($args['id']);        
       
        if(!$CourseSession)
         {
                 return Error::createLocatedError("COURSESESSION-UPDATE-RECORD_NOT_FOUND");
         }
        $CourseSession_result= $CourseSession->fill($args);
        $CourseSession_result->save();       
       
        return $CourseSession_result;
        
    }
}
