<?php

namespace App\GraphQL\Queries\AbsencePresence;

use App\Models\AbsencePresence;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;

final class GetAbsencePresences
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
   

    function resolveAbsencePresence($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $branch_id = auth()->guard('api')->user()->branch_id;

       // return AuthRole::CheckAccessibility(); 
        if( AuthRole::CheckAccessibility("AbsencePresence")){
            $AbsencePresence= AbsencePresence::where('deleted_at', null)
            ->whereHas('courseSession.course', function ($query) use ($branch_id) {
                if($branch_id!=""){
                    $query->where('branch_id', $branch_id);
                }  
                 return true;
            })->with('courseSession.course')
            ->whereHas('user',function($query) use($args){
                       if(isset($args['user_id_creator'])){
                           $query->where('users.id',$args['user_id_creator']);
                       }  
                       // if(isset($args['teacher_id'])){

                       //     $query->where('users1.id',$args['teacher_id']);
                           
                       // }
                       return true;  

             })
             ->with('user')
             ->whereHas('teacher',function($query) use($args){
                       if(isset($args['teacher_id']))
                           $query->where('users.id',$args['teacher_id']);
                       else
                           return true;
             })
             ->with('teacher')
             ->whereHas('courseSession',function($query) use($args){
                       if(isset($args['course_session_id']))
                           $query->where('course_sessions.id',$args['course_session_id']);
                       if(isset($args['course_session_date']))
                       {
                           $query->where('course_sessions.start_date',$args['course_session_date']);
                       }    
                       else
                           return true;
               })
               ->with('courseSession');


                return $AbsencePresence;
        }
       // return Error::createLocatedError("AbsencePresence-NotAccess-ToGETALL");
        $AbsencePresence =AbsencePresence::where('deleted_at',null)
        ->where('id',-1);       
        return  $AbsencePresence;
        // $user_role=auth()->guard('api')->user()->group->type; 
        // return User::find(1)
        // ->with('group')
        // ->paginate(10);
       // 
        ////return error you didn't access to this action.
       
    }
}
