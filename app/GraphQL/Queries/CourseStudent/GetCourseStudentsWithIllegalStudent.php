<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;
use Log;

final class GetCourseStudentsWithIllegalStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    { 
        // if( AuthRole::CheckAccessibility("GetCourseStudentsWithIllegalStudent"))
        // {      
        //     return DB::table('course_students');
       
       
        // }
        // return  DB::table('course_students')->where('id',-1);
    
    }
}
