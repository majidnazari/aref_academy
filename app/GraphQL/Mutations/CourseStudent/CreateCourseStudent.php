<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateCourseStudent
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
        $is_exist= CourseStudent::where('course_id',$args['course_id'])
        ->where('student_id',$args['student_id'])
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("COURSESTUDENT-CREATE-RECORD_IS_EXIST");
         }
        $CourseStudente = [
            'course_id' => $args['course_id'],
            //'course_session_id' => $args['course_session_id'],
            'student_id' => $args['student_id'],
            'manager_status' => isset($args['status']) ? $args['status'] : 'pending',
            'financial_status' => isset($args['financial_status']) ? $args['financial_status'] : 'pending',
            'student_status' => isset($args['student_status']) ? $args['student_status'] : 'ok',
            'user_id_manager' => isset($args['user_id_manager']) ? $args['user_id_manager'] : 0,
            'user_id_financial' => isset($args['user_id_financial']) ? $args['user_id_financial'] : 0,
            'user_id_student_status' => isset($args['user_id_student_status']) ? $args['user_id_student_status'] :  $user_id,
            
            'user_id_creator' =>  $user_id,
            'user_id_approved' => 0            
        ];
        $CourseStudent_result = CourseStudent::create($CourseStudente);
        return $CourseStudent_result;
    }
}
