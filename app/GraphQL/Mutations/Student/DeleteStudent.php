<?php

namespace App\GraphQL\Mutations\Student;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Student;
use Illuminate\Support\Facades\Http;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
final class DeleteStudent
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
        $response = Http::delete(env('REMOTE_SERVER')."student_destroy/".$args['id']);       
        return $response;
    }
}
