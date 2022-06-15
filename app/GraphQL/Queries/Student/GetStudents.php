<?php

namespace App\GraphQL\Queries\Student;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Http;

final class GetStudents
{
    public function resolveStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

       // $first_name = $args['first_name'];
        // $last_name=$args['last_name'];
        // $phone=$args['phone'];
        // $level=$args['level'];
        // $egucation_level=$args['egucation_level'];
        // $parents_job_title=$args['parents_job_title'];
        // $home_phone=$args['home_phone'];
        // $father_phone=$args['father_phone'];
        // $mother_phone=$args['mother_phone'];
        // $major=$args['major'];
        // $data = [
        //     "first_name" => $args['first_name'] ??  ,
        //     "last_name" => $args['last_name'],
        //     "phone" => $args['phone'],
        //     "level" => $args['level'],
        //     "egucation_level" => $args['egucation_level'],
        //     "parents_job_title" => $args['parents_job_title'],
        //     "home_phone" => $args['home_phone'],
        //     "father_phone" => $args['father_phone'],
        //     "mother_phone" => $args['mother_phone'],
        //     "major" => $args['major']
        // ];
        // $response = Http::get(env('REMOTE_SERVER').'getStudents');

        $response = Http::get(env('REMOTE_SERVER') . "student_index", $args);
        //return $response;
        $result = json_decode($response->body());
        return $result;
        // $first_name = $args['first_name'];

        // return array_filter($result, function ($item) use ($first_name)
        // {
        //     return \strpos($item->first_name, $first_name) !== false;
        // });   
    }
}
