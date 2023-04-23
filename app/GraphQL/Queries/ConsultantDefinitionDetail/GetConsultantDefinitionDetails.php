<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use Carbon\Carbon;
use AuthRole;
use Log;

final class GetConsultantDefinitionDetails
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantDefinitionDetail($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $userType=auth()->guard('api')->user()->group->type;
        //Log::info("the b are:" . json_encode($branch_id));
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("ConsultantDefinitionDetail")) {
           if( isset($args['session_date_days']))
           {
                $daysin=[];
                $now = Carbon::now();
            // $now = Carbon::create($now);
                $firstofyear=$now->copy()->startOfYear();
                $endOfYear   = $now->copy()->endOfYear();
                //    $test= $now->startOfYear(Carbon::SATURDAY); $now

                //Log::info(" session_date_days  is: " . json_encode($args['session_date_days']). " datee is" .  $endOfYear);
       
           
                foreach($args['session_date_days'] as $day){
                   //Log::info("***********************************************************"); 
                   //$firstOfDay= Carbon::parse('first monday')->toDateString();
                   $days=Carbon::parse("first $day of January " . $now->year);
                   //Log::info("day is: " . $days ); 
                   $daysin[]=$days->toDateString();
                  // $nextday= $day->addDays('7');                   
                   //$nextday=$days;
                   while( $endOfYear >  $days)
                   {    
                   
                                   
                    $days->addDays('7'); 
                    //Log::info("day is: " . $days );  
                   $daysin[]=$days->toDateString();

                    //$daytmp=$nextday;
                    
                   }
                  
                }
               // Log::info("daysin are : " . json_encode($daysin) );  

            }
            // Log::info('branch_id'. $branch_id);
          // Log::info('type'. auth()->guard('api')->user()->group->type );

            $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('deleted_at', null); //->orderBy('id','desc');   
            
                isset($args['consultant_id']) ? $ConsultantDefinitionDetail->where('consultant_id', $args['consultant_id']): '';
            
                isset($args['branch_id']) ? $ConsultantDefinitionDetail->where('branch_id', $args['branch_id']): $ConsultantDefinitionDetail->whereIn('branch_id', $branch_id);       
                isset($args['session_date_from']) ? $ConsultantDefinitionDetail->where('session_date','>=', $args['session_date_from']): '';
                isset($args['session_date_to']) ? $ConsultantDefinitionDetail->where('session_date','<=', $args['session_date_to']): '';
                isset($args['consultant_test_id']) ? $ConsultantDefinitionDetail->where('consultant_test_id', $args['consultant_test_id']): '';
                isset($args['user_id']) ? $ConsultantDefinitionDetail->where('user_id', $args['user_id']): '';
                isset($args['start_hour_from']) ? $ConsultantDefinitionDetail->where('start_hour','>=', $args['start_hour_from']): '';
                isset($args['start_hour_to']) ? $ConsultantDefinitionDetail->where('start_hour','<=', $args['start_hour_to']): '';
                isset($args['end_hour_from']) ? $ConsultantDefinitionDetail->where('end_hour','>=', $args['end_hour_from']): '';
                isset($args['end_hour_to']) ? $ConsultantDefinitionDetail->where('end_hour','<=', $args['end_hour_to']): '';
                isset($args['student_status']) ? $ConsultantDefinitionDetail->whereIn('student_status', $args['student_status'])  : '';
                isset($args['student_id']) ? $ConsultantDefinitionDetail->where('student_id', $args['student_id']): '';
                isset($args['absent_present_description']) ? $ConsultantDefinitionDetail->where('absent_present_description', $args['absent_present_description']): '';
                isset($args['test_description']) ? $ConsultantDefinitionDetail->where('test_description', $args['test_description']): '';
                isset($args['step']) ? $ConsultantDefinitionDetail->where('step', $args['step']): '';
                isset($args['session_date_days']) ? $ConsultantDefinitionDetail->whereIn('session_date',$daysin): '';
               
                return $ConsultantDefinitionDetail;    

            
        }
        return ConsultantDefinitionDetail::where('deleted_at', null)
            ->where('id', -1);
    }
    
}
