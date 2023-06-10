<?php

namespace App\GraphQL\Mutations\Student;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Http;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
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
        $student_date=[
            'phone' => $args['phone'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
            'nationality_code' => $args['nationality_code'],
            'level' => $args['level'],
            'egucation_level' => $args['egucation_level'],
            'parents_job_title' => $args['parents_job_title'],
            'home_phone' => $args['home_phone'],
            'father_phone' => $args['father_phone'],
            'mother_phone' => $args['mother_phone'],            
            'major' => $args['major'],
            'description' => $args['description'] 
            
        ];
        $response = Http::put(env('REMOTE_SERVER')."student_update/".$args['id'],$student_date);
        return $response;
        
    }
}
