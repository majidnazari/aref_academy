<?php

namespace App\GraphQL\Queries\Student;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Http;

final class GetStudents
{
    public function resolveStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

       // $response = Http::get(env('REMOTE_SERVER').'getStudents');
       
        $response = Http::get(env('REMOTE_SERVER')."student_index");
        $result = json_decode($response->body());
        return $result;
        // $first_name = $args['first_name'];
      
        // return array_filter($result, function ($item) use ($first_name)
        // {
        //     return \strpos($item->first_name, $first_name) !== false;
        // });   
    }
}
