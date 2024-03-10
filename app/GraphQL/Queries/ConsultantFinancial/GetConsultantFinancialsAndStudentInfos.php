<?php

namespace App\GraphQL\Queries\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use AuthRole;
use Log;


final class GetConsultantFinancialsAndStudentInfos
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }    
    function resolveConsultantFinancialAndStudentInfos($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
       
        if (AuthRole::CheckAccessibility("ConsultantFinancialAndStudentInfos")) {

            $ConsultantFinancial = ConsultantFinancial::where('deleted_at', null); //->orderBy('id','desc');   

            isset($args['consultant_id']) ? $ConsultantFinancial->where('consultant_id', $args['consultant_id']) : '';
            isset($args['student_id']) ? $ConsultantFinancial->where('student_id', $args['student_id']) : '';
            // if($branch_id){
            //     //isset($args['branch_id']) ? $ConsultantFinancial->where('branch_id', $args['branch_id']) : $ConsultantFinancial->whereIn('branch_id', $branch_id);
            //     $ConsultantFinancial->where('branch_id',$branch_id);
            // }
            
            // //isset($args['branch_id']) ? $ConsultantFinancial->where('branch_id', $args['branch_id']) : '';
            isset($args['manager_status']) ? $ConsultantFinancial->where('manager_status', $args['manager_status']) : null;            
            isset($args['financial_status']) ? $ConsultantFinancial->where('financial_status', $args['financial_status']) : null;
            isset($args['student_status']) ? $ConsultantFinancial->where('student_status', $args['student_status']) : null;
            isset($args['financial_refused_status']) ? $ConsultantFinancial->where('financial_refused_status', $args['financial_refused_status']) : null;
            // isset($args['user_id_manager']) ? $ConsultantFinancial->where('user_id_manager', $args['user_id_manager']) : '';
            // isset($args['user_id_financial']) ? $ConsultantFinancial->where('user_id_financial',  $args['user_id_financial']) : '';
            // isset($args['user_id_student_status']) ? $ConsultantFinancial->where('user_id_student_status', $args['user_id_student_status']) : '';
            isset($args['description']) ? $ConsultantFinancial->where('description','LIKE', '%' . $args['description'] . '%') : null;
            // isset($args['date_from']) ? $ConsultantFinancial->where('created_at','>=', $args['date_from']) : '';
            // isset($args['date_to']) ? $ConsultantFinancial->where('created_at','<=', $args['date_to']) : '';
          if(isset($args['major'])){
            $ConsultantFinancial->whereHas('studentInfos', function ($query) use ($args) {               
                $query->where('major', $args['major']);               
            })        
            ->with(["studentInfos"]);
          }
          if(isset($args['education_level'])){
            $ConsultantFinancial->whereHas('studentInfos', function ($query) use ($args) {                
                $query->where('education_level', $args['education_level']);                
            })        
            ->with(["studentInfos"]);
          }
          if(isset($args['nationality_code'])){
            $ConsultantFinancial->whereHas('studentInfos', function ($query) use ($args) {                
                $query->where('nationality_code','LIKE','%'. $args['nationality_code'] .'%');
            })        
            ->with(["studentInfos"]);
          }
          if(isset($args['phone'])){
            $ConsultantFinancial->whereHas('studentInfos', function ($query) use ($args) {              
                $query->where('phone','LIKE','%'. $args['phone'] .'%');              
            })        
            ->with(["studentInfos"]);
          }
          if(isset($args['school_name'])){
            $ConsultantFinancial->whereHas('studentInfos', function ($query) use ($args) {              
                $query->where('school_name','LIKE','%'. $args['school_name'] .'%');              
            })        
            ->with(["studentInfos"]);
          }


            return $ConsultantFinancial;
        }
        return ConsultantFinancial::where('deleted_at', null)
            ->where('id', -1);
    }   
}
