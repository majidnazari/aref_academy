<?php

namespace App\GraphQL\Queries\StudentWarningHistory;
use GraphQL\Type\Definition\ResolveInfo;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use AuthRole;
use GraphQL\Error\Error;

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
    function resolveStudentWarningHistory($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {        

        if( AuthRole::CheckAccessibility("StudentWarningHistory")){
            $student_warning_histories= StudentWarningHistory::where('deleted_at', null);//->orderBy('id','desc');
            return $student_warning_histories;
        }
        $student_warning_histories =StudentWarningHistory::where('deleted_at',null)
        ->where('id',-1);       
        return  $student_warning_histories;
    }
    
}
