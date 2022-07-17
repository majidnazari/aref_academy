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
use GraphQl\Error\Error;

final class CreateStudent
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
        //return "yyyy";      
        $user_id=auth()->guard('api')->user()->group->type;
        return $user_id;
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
            'description' => $args['description'] ,
            'role' => 'hassan'  ,
            //'introducing' => $args['introducing'],.
           // 'student_phone' => $args['student_phone'],
            //'cities_id' => $args['cities_id'],
            //'sources_id' => $args['sources_id'],
            //'supporters_id' => $args['supporters_id'],
            //'archived' => $args['archived']



            // 'user_id_creator' => $user_id,
            // 'name' => $args['name'],
            // 'active' => $args['active']
            
        ];
        // $is_exist= Http::get(env('REMOTE_SERVER')."student_show/".$id);      
       
        // if($is_exist)
        //  {
        //          return Error::createLocatedError("FAULT-CREATE-RECORD_IS_EXIST");
        //  }
        
        $response = Http::post(env('REMOTE_SERVER')."student_store",$student_date);   
       // $student_resut=Student::create($student_date);
        return $response;
    }
}
