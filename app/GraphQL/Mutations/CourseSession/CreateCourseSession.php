<?php

namespace App\GraphQL\Mutations\CourseSession;

use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateCourseSession
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
        $user_id = auth()->guard('api')->user()->id;
        $CourseSession_date = [
            'user_id_creator' => $user_id,
            'course_id' => $args['course_id'],
            'start_date' => $args['start_date'],
            'start_time' => $args['start_time'],
            'end_time' => $args['end_time'],
        ];
        $CourseSession_result = CourseSession::create($CourseSession_date);
        return $CourseSession_result;
    }
}
