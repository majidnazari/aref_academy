<?php

namespace App\GraphQL\Queries\AbsencePresence;

use App\Models\AbsencePresence;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;

final class GetAbsencePresence
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveAbsencePresenceAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        //return AuthRole::CheckAccessibility(); 
        $AbsencePresence= AbsencePresence::find($args['id']);
        return $AbsencePresence;
    }
    public function resolveGetAbsencePresence($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // //Log::info(json_encode($context->request()));
        // $response = Http::get(env('REMOTE_SERVER').'getStudent/'.$rootValue['student_id']);
        // //$getPost= Post::find($args['id']);
        // return $response;

        $AbsencePresence= AbsencePresence::where('course_session_id',$rootValue['course_session_id'])
        ->where('student_id',$rootValue['student_id'])
        ->first();
        return $AbsencePresence;
    }
}
