<?php

namespace App\GraphQL\Queries\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use AuthRole;
use Log;


final class GetConsultantFinancials
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveGetConsultantFinancialAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        $ConsultantFinancial = ConsultantFinancial::where('id', $args['id']);

        if ($branch_id) {
            return  $ConsultantFinancial->where('branch_id', $branch_id)->first();
        }

        return $ConsultantFinancial->first();
    }

    function resolveConsultantFinancial($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        // $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        // $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        // $userType = auth()->guard('api')->user()->group->type;
        // $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("ConsultantFinancial")) {

            $ConsultantFinancial = ConsultantFinancial::where('deleted_at', null); //->orderBy('id','desc');   

            isset($args['consultant_id']) ? $ConsultantFinancial->where('consultant_id', $args['consultant_id']) : '';
            isset($args['student_id']) ? $ConsultantFinancial->where('student_id', $args['student_id']) : '';
            if($branch_id){
                //isset($args['branch_id']) ? $ConsultantFinancial->where('branch_id', $args['branch_id']) : $ConsultantFinancial->whereIn('branch_id', $branch_id);
                $ConsultantFinancial->where('branch_id',$branch_id);
            }
            
            //isset($args['branch_id']) ? $ConsultantFinancial->where('branch_id', $args['branch_id']) : '';
            isset($args['manager_status']) ? $ConsultantFinancial->where('manager_status', $args['manager_status']) : '';
            
            isset($args['financial_status']) ? $ConsultantFinancial->where('financial_status', $args['financial_status']) : '';
            isset($args['student_status']) ? $ConsultantFinancial->where('student_status', $args['student_status']) : '';
            isset($args['financial_refused_status']) ? $ConsultantFinancial->where('financial_refused_status', $args['financial_refused_status']) : '';
            isset($args['user_id_manager']) ? $ConsultantFinancial->where('user_id_manager', $args['user_id_manager']) : '';
            isset($args['user_id_financial']) ? $ConsultantFinancial->where('user_id_financial',  $args['user_id_financial']) : '';
            isset($args['user_id_student_status']) ? $ConsultantFinancial->where('user_id_student_status', $args['user_id_student_status']) : '';
            isset($args['description']) ? $ConsultantFinancial->where('description', $args['description']) : '';
            isset($args['date_from']) ? $ConsultantFinancial->where('created_at','>=', $args['date_from']) : '';
            isset($args['date_to']) ? $ConsultantFinancial->where('created_at','<=', $args['date_to']) : '';
           if (isset($args['total_present']) )
           {
            $ConsultantFinancial
            ->groupBy('student_id')
            ->havingRaw("COUNT(student_id) = ".$args['total_present']  );
            //    $consultantFinancial_copy = clone $ConsultantFinancial;
            //    $result=$this->find_total_present_in_consultant_fifancial($ConsultantFinancial,$args['total_present']);

           }

            return $ConsultantFinancial;
        }
        return ConsultantFinancial::where('deleted_at', null)
            ->where('id', -1);
    }

    public function find_total_present_in_consultant_fifancial($consultantFinancial_copy,$total_present){


       $result= $consultantFinancial_copy
       ->groupBy('student_id')
       ->havingRaw("COUNT(student_id) =  $total_present" );
       return $result;
      
       //Log::info("result are:" . json_encode($result));
    }
}
