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

final class CreateCourse
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
        $course_date=[
            'user_id_creator' => $user_id,
            "branch_id" => $args['branch_id'],
            "year_id" => $args['year_id'],
            "teacher_id" => $args['teacher_id'],            
            'name' => $args['name'],
            'gender' => $args['gender'],
            "lesson_id"=> $args["lesson_id"],
            "education_level"=> $args["education_level"],
            "financial_status" => isset($args["financial_status"]) ? $args["financial_status"] : 'pending' ,
            "user_id_financial" => isset($args["user_id_financial"]) ? $args["user_id_financial"] : null ,            
            "type" => $args["type"],
           
            
        ];
        $is_exist= Course::where($course_date)->first();
        // ->where('name',$args['name'])              
        // //->where('description',$args['description'])              
        // ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("COURSE-CREATE-RECORD_IS_EXIST");
         }
        $course_result=Course::create($course_date);
        return $course_result;
    }
}
