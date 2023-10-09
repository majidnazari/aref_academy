<?php 
namespace App\GraphQL\Mutations\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Carbon\Carbon;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;
use Symfony\Component\Mime\Message;

final class CreateConsultantFinancial
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        
        $now=Carbon::now();
        $user_id=auth()->guard('api')->user()->id;
        $ConsultantFinancialResult=[
            "user_id_creator" => $user_id,
            "branch_id" => isset($args['branch_id']) ? $args['branch_id'] : null,
            "consultant_id" => $args['consultant_id'],
            "year_id" => isset($args['year_id']) ? $args['year_id'] : null,
           // "consultant_definition_detail_id" => isset($args['consultant_definition_detail_id']) ? $args['consultant_definition_detail_id'] : null,
            "student_id" => $args['student_id'],
            "manager_status" => isset($args['manager_status']) ? $args['manager_status'] : "pending",
            "financial_status" => isset($args['financial_status']) ? $args['financial_status'] : "pending",
            "student_status" => isset($args['student_status']) ? $args['student_status'] : "ok",
            "financial_refused_status" => isset($args['financial_refused_status']) ? $args['financial_refused_status'] : 'noMoney',            
            "description" => isset($args['description']) ? $args['description'] : null,
            "financial_status_updated_at" => isset($args['financial_status']) ?  $now : null,

        ];
        $is_exist= ConsultantFinancial::where('consultant_id',$args['consultant_id'])
        ->where('student_id',$args['student_id'])              
        //->where('consultant_definition_detail_id',isset($args['consultant_definition_detail_id']) ? $args['consultant_definition_detail_id'] : null)              
        ->where('year_id',isset($args['year_id']) ? $args['year_id'] : null)            
        ->where('branch_id',isset($args['branch_id']) ? $args['branch_id'] : null)            
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("CONSULTANTFINANCIAL-CREATE-RECORD_IS_EXIST");
         }
        $ConsultantFinancial_result=ConsultantFinancial::create($ConsultantFinancialResult);
        return $ConsultantFinancial_result;       
       
    }
}
