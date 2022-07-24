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
        $name=$args['name'] ??  "";
        $price=$args['price'] ?? 0;
        $special=$args['special'] ?? false;
        $CourseSession_date = [
            'user_id_creator' => $user_id,
            'branch_class_room_id' => $args['branch_class_room_id'],
            'course_id' => $args['course_id'],
            
            'name' => $name,
            'price' => $price,
            'special' => $special,
            'start_date' => $args['start_date'],
            'start_time' => $args['start_time'],
            'end_time' => $args['end_time'],
        ];
        $is_exist= CourseSession::where($CourseSession_date)->first();
        
        if($is_exist)
         {
                 return Error::createLocatedError("COURSESESSION-CREATE-RECORD_IS_EXIST");
         }
        $CourseSession_result = CourseSession::create($CourseSession_date);
        return $CourseSession_result;
    }
    public function resolverByDuringDate($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $date = $args['start_date'];
        $to_date = $args['end_date'];
        $days = $args['days'];   
        $name=$args['name'] ??  "";
        $price=$args['price'] ?? 0;
        $special=$args['special'] ?? false;
        $courseSession=[];
        while (strtotime($date) <= strtotime($to_date)) {
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            if (in_array($this->getNameOfTheDate($date), $days)) {
                $courseSession[] = CourseSession::create([
                    'user_id_creator' => $user_id,
                    'branch_class_room_id' => $args['branch_class_room_id'],
                    'course_id' => $args['course_id'],
                    'name' => $name,
                    'price' => $price,
                    'special' => $special,
                    'start_date' => $date,
                    'start_time' => $args['start_time'],
                    'end_time' => $args['end_time'],
                ]);
            
            }
        }

        return $courseSession;

        // $user_id = auth()->guard('api')->user()->id;
        // $CourseSession_date = [
        //     'user_id_creator' => $user_id,
        //     'course_id' => $args['course_id'],
        //     'name' => $args['name'],
        //     'start_date' => $args['start_date'],
        //     'start_time' => $args['start_time'],
        //     'end_time' => $args['end_time'],
        // ];
        // $CourseSession_result = CourseSession::create($CourseSession_date);
        // return $CourseSession_result;
    }
    public function getNameOfTheDate($date)
    {

        $timestamp = strtotime($date);
        $day = date('l', $timestamp);
        return $day;
    }
   
}
