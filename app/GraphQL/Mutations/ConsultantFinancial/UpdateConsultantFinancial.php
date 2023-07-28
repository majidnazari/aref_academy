<?php

namespace App\GraphQL\Mutations\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class UpdateConsultantFinancial
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
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id_creator"]=$user_id;
       // $ConsultantFinancial=ConsultantFinancial::query();
        $ConsultantFinancial=ConsultantFinancial::where("consultant_id",$args['consultant_id']);
        $ConsultantFinancial->where("student_id",$args['student_id']);
        if(isset($args['branch_id']))
        {
            $ConsultantFinancial->where("branch_id",$args['branch_id']);
        }
        if(isset($args['year_id']))
        {
            $ConsultantFinancial->where("year_id",$args['year_id']);
        }
        $ConsultantFinancial=$ConsultantFinancial->orderBy('updated_at','desc')->orderBy('created_at','desc')->first();
       
        //Log::info("the user is:" .json_encode($ConsultantFinancial ));
        // $ConsultantFinancial->where("student_id",$args['student_id']);

        // $ConsultantFinancial=ConsultantFinancial::where("consultant_id",$args['consultant_id'])
        // ->where("student_id",$args['student_id'])
        // ->where("branch_id",isset($args['branch_id']) ? $args['branch_id'] : null)
        // ->where("year_id",isset($args['year_id']) ? $args['year_id'] : null)
        // ->first();
        
        if(!$ConsultantFinancial)
        {
            return Error::createLocatedError("CONSULTANTFINANCIAL-UPDATE-RECORD_NOT_FOUND");
        }
        $data=[
            "consultant_id"=>$args['consultant_id'],
            "student_id"=>$args['student_id'],
            "branch_id"=>isset($args['branch_id']) ? $args['branch_id'] : null,
            "year_id"=>isset($args['year_id']) ? $args['year_id'] : null,
           // "consultant_definition_detail_id"=>$args['consultant_definition_detail_id'],
           
        ];
        $exist_before=ConsultantFinancial::where($data)->exists();        
        if($exist_before)
        {
            return Error::createLocatedError("CONSULTANTFINANCIAL-UPDATE-RECORD_EXIST_BEFORE");
        }
        $ConsultantFinancial_filled= $ConsultantFinancial->fill($args);
        $ConsultantFinancial->save(); 
        return $ConsultantFinancial;
        
    }
}
