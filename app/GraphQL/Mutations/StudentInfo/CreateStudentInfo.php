<?php

namespace App\GraphQL\Mutations\StudentInfo;

use App\Models\StudentInfo;
use App\Models\User;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Carbon\Carbon;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;
use Symfony\Component\Mime\Message;

final class CreateStudentInfo
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

        $now = Carbon::now();
        $user_id = auth()->guard('api')->user()->id;
        //$branch_id_consultant=User::where('id',$args['consultant_id'])->first()->branch_id ;
        //Log::info( $branch_id_consultant );
        $StudentInfo = [
            "user_id_creator" => $user_id,
            "student_id" => $args['student_id'],
            "first_name" => isset($args['first_name']) ? $args['first_name'] : null,
            "last_name" =>  isset($args['last_name']) ? $args['last_name'] : null,
            "school_name" =>  isset($args['last_name']) ? $args['school_name'] : null,
            // "consultant_definition_detail_id" => isset($args['consultant_definition_detail_id']) ? $args['consultant_definition_detail_id'] : null,
            "nationality_code" =>  isset($args['nationality_code']) ? $args['nationality_code'] : null,
            "phone" =>  isset($args['phone']) ? $args['phone'] : null,
            "major" =>  isset($args['major']) ? $args['major'] : null,
            "education_level" =>  isset($args['education_level']) ? $args['education_level'] : null,
            "concours_year" =>  isset($args['concours_year']) ? $args['concours_year'] : null,


        ];
        $is_exist = StudentInfo::where('student_id', $args['student_id'])->first();

        // Log::info("student is: " . json_encode($is_exist));

        if ($is_exist) {
            //  Log::info(" if student exist student is: " . json_encode($is_exist));

            return;
            // return Error::createLocatedError("STUDENTINFO-CREATE-RECORD_IS_EXIST");
            //return Error::createLocatedError("ایجاد مالی مشاوران:رکورد مورد نظر تکراری است.");
        }
        // Log::info(" should insert student is: " );

        $Student_info_result = StudentInfo::create($StudentInfo);
        return $Student_info_result;
    }
}
