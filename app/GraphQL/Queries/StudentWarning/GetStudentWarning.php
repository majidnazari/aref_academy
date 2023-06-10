<?php

namespace App\GraphQL\Queries\StudentWarning;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\StudentWarning;


final class GetStudentWarning
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentWarning($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;

        $student_warning = StudentWarning::where('id', $args['id'])
            ->whereHas('course', function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
                return true;
            })->with('course')->first();
        return $student_warning;
    }
}
