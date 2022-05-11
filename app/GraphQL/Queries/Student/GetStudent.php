<?php

namespace App\GraphQL\Queries\Student;

use App\Models\Student;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Http;

final class GetStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $student =new Student();
        $response = Http::get(env('REMOTE_SERVER')."student_show/".$args['id']);  
        //$student['first_name']= $response['first_name'];   
        return $response ;   
        //return $args['id'];
        // $student_result= Http::get('http://127.0.0.1:8001/api/student_show/'.$args['id']);
        // return $student_result  ;
        
    }
}
