<?php

namespace App\GraphQL\Queries\Student;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Http;
use Log;

final class GetStudent
{
    function resolveStudentAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $id = isset($args["id"]) ? $args["id"] : $rootValue['student_id'];
        return Http::get(env('REMOTE_SERVER')."student_show/".$id);  
    }
    public function resolveGetStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       // Log::info(json_encode($context));
        $response = Http::get(env('REMOTE_SERVER').'getStudent/'.$rootValue['student_id']);
        //$getPost= Post::find($args['id']);
        return $response;
    }
}
