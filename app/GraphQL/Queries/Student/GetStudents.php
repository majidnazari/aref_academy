<?php

namespace App\GraphQL\Queries\Student;

use App\Models\Student;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Http;

final class GetStudents
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveStudent($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $response = Http::get(env('REMOTE_SERVER')."student_index");
        return $response ;   
    }
}
