<?php

namespace App\GraphQL\Mutations\Student;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Student;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateStudent
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
       // $user_id=auth()->guard('api')->user()->id;
        $student_date=[
            'phone' => $args['phone'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
            'level' => $args['level'],
            'egucation_level' => $args['egucation_level'],
            'parents_job_title' => $args['parents_job_title'],
            'home_phone' => $args['home_phone'],
            'father_phone' => $args['father_phone'],
            'mother_phone' => $args['mother_phone'],
            //'school' => $args['school'],
            //'average' => $args['average'],
            'major' => $args['major'],
            'description' => $args['description']   
            //'introducing' => $args['introducing'],
           // 'student_phone' => $args['student_phone'],
            //'cities_id' => $args['cities_id'],
            //'sources_id' => $args['sources_id'],
            //'supporters_id' => $args['supporters_id'],
            //'archived' => $args['archived']
        ];
        $response = Http::put(env('REMOTE_SERVER')."student_update/".$args['id'],$student_date);   
        // $student_resut=Student::create($student_date);
         return $response;
        
    }
}
