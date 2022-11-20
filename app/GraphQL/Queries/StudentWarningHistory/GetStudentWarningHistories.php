<?php

namespace App\GraphQL\Queries\StudentWarningHistory;

use GraphQL\Type\Definition\ResolveInfo;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use AuthRole;
use GraphQL\Error\Error;
use Log;

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
        Log::info("this is run");
        // dd("ggg");
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        Log::info("the b are:" . json_encode($branch_id));
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("StudentWarningHistory")) {
            $student_warning_histories = StudentWarningHistory::where('deleted_at', null)
                ->whereHas('course', function ($query) use ($branch_id) {
                    if ($branch_id != "") {
                        $query->whereIn('branch_id', $branch_id);
                    }
                    return true;
                })->with('course')
                ->whereHas('user_id_creator', function ($query) use ($args) {
                    if (isset($args['user_id_creator'])) {
                        $query->where('users.id', $args['user_id_creator']);
                    }
                    // if(isset($args['teacher_id'])){

                    //     $query->where('users1.id',$args['teacher_id']);

                    // }
                    return true;
                })
                ->with('user_creator')
                ->whereHas('user_id_updater', function ($query) use ($args) {
                    if (isset($args['user_id_updater'])) {
                        $query->where('users.id', $args['user_id_updater']);
                    }
                    // if(isset($args['teacher_id'])){

                    //     $query->where('users1.id',$args['teacher_id']);

                    // }
                    return true;
                })
                ->with('user_updater'); //->orderBy('id','desc');
            return $student_warning_histories;
        }
        $student_warning_histories = StudentWarningHistory::where('deleted_at', null)
            ->where('id', -1);
        return  $student_warning_histories;
    }
}
