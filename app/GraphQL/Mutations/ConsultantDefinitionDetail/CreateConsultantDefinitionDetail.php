<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class CreateConsultantDefinitionDetail
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
        // Log::info("start hour is:" . $args['start_hour']);
        // Log::info("end_hour  is:" . $args['end_hour']);
        // Log::info("days  is:" .json_encode( $args['days']));
        $now=Carbon::now();
        $now=Carbon::parse('next saturday')->toDateString();

        foreach($args['days'] as $day)
        {
            
        }
      // return null;
        $user_id=auth()->guard('api')->user()->id;
        $consultant_definition_detail_date=[
            'consultant_id' => $args['consultant_id'],
            "branch_id" =>isset($args['branch_id']) ? $args['branch_id'] : null,
            "user_id" => $user_id,
            "start_hour" => $args['start_hour'],            
            'end_hour' => $args['end_hour'],
            'step' => $args['step'],
            'session_date' => $now           
            
        ];
        $is_exist= ConsultantDefinitionDetail::where($consultant_definition_detail_date)
        // ->where('start_hour',$args['start_hour'])
        // ->where('end_hour',$args['end_hour'])
        // ->where('session_date',$now)
        ->first();
        // ->where('name',$args['name'])              
        // //->where('description',$args['description'])              
        // ->first();
        //Log::info("record  is:" .json_encode($consultant_definition_detail_date));
        //return $is_exist;
        if($is_exist)
        {
                 return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_RECORD-IS-EXIST");
        }
        $consultant_definition_detail_date_result=ConsultantDefinitionDetail::create($consultant_definition_detail_date);
        return $consultant_definition_detail_date_result;
    }
}
