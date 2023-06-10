<?php

namespace App\GraphQL\Queries\StudentWarningHistory;

use GraphQL\Type\Definition\ResolveInfo;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\StudentWarningHistory;
use AuthRole;

final class GetStudentWarningHistories
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveStudentWarningHistoriesAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;

        if (AuthRole::CheckAccessibility("StudentWarningHistory")) {

            $student_warning_histories = StudentWarningHistory::where('deleted_at', null)
                ->whereHas('course', function ($query) use ($branch_id) {
                    if ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    }
                    return true;
                })
                ->with(["course", "user_creator", "user_updater"]);

            return $student_warning_histories;
        }
        $student_warning_histories = StudentWarningHistory::where('deleted_at', null)
            ->where('id', -1);
        return  $student_warning_histories;
    }
}
