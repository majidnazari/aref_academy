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
        $now = Carbon::now();
        $user_id = auth()->guard('api')->user()->id;
        $start_hour = $args['start_hour'];
        $end_hour = $args['end_hour'];
        $data=[];

        $all_of_consultant_data=ConsultantDefinitionDetail::where('consultant_id',$args['consultant_id'])->where('user_id' , $user_id)->get();
        //Log::info(json_encode($all_of_consultant_data));
        foreach ($args['days'] as $day) {
            $dayOfWeek = Carbon::parse('next ' . $day)->toDateString();
            $start_hour = $args['start_hour'];
            $end_hour = $args['end_hour'];
            do {
                $next_time = Carbon::parse($start_hour)->addMinutes($args['step'])->format("H:i");

                $consultant_definition_detail_date = [
                    'consultant_id' => $args['consultant_id'],
                    'branch_id' => isset($args['branch_id']) ? $args['branch_id'] : null,
                    'user_id' => $user_id,
                    'start_hour' => $start_hour,
                    'end_hour' => $next_time,
                    'step' => $args['step'],
                    'session_date' => $dayOfWeek

                ];
                 $is_exist = $all_of_consultant_data->where('consultant_id',$args['consultant_id'])
                 ->where('branch_id',$args['branch_id'])
                 ->where('user_id',$user_id)
                 ->where('start_hour',$start_hour)
                 ->where('end_hour',$next_time)
                 ->where('step',$args['step'])
                 ->where('session_date',$dayOfWeek)
                 ->first();
                // Log::info(json_encode($is_exist). " " . $user_id);
                $start_hour = $next_time;

                if ($is_exist) {

                   // Log::info("exist");
                    continue;
                    //return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_RECORD-IS-EXIST");
                }
               // Log::info("days  is:" .json_encode(  $consultant_definition_detail_date));

                // $consultant_definition_detail_date_result = ConsultantDefinitionDetail::create($consultant_definition_detail_date);
                $data[]=$consultant_definition_detail_date ;
               
            } while (Carbon::parse($start_hour) < Carbon::parse($end_hour));
        }
        
        ConsultantDefinitionDetail::insert($data);
        // $result=ConsultantDefinitionDetail::where('consultant_id',$args['consultant_id'])->where('user_id' , $user_id)->get(); //
        $result=ConsultantDefinitionDetail::whereNotIn('id',$all_of_consultant_data->pluck('id'))->get();
        Log::info($result);



        // return null;

        // $consultant_definition_detail_date=[
        //     'consultant_id' => $args['consultant_id'],
        //     "branch_id" =>isset($args['branch_id']) ? $args['branch_id'] : null,
        //     "user_id" => $user_id,
        //     "start_hour" => $args['start_hour'],            
        //     'end_hour' => $args['end_hour'],
        //     'step' => $args['step'],
        //     'session_date' => $now           

        // ];
        // $is_exist = ConsultantDefinitionDetail::where($consultant_definition_detail_date)
        //     // ->where('start_hour',$args['start_hour'])
        //     // ->where('end_hour',$args['end_hour'])
        //     // ->where('session_date',$now)
        //     ->first();
        // ->where('name',$args['name'])              
        // //->where('description',$args['description'])              
        // ->first();
        //Log::info("record  is:" .json_encode($consultant_definition_detail_date));
        //return $is_exist;
        // if ($is_exist) {
        //     return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CREATE_RECORD-IS-EXIST");
        // }
        //$consultant_definition_detail_date_result = ConsultantDefinitionDetail::create($consultant_definition_detail_date);
        //return $consultant_definition_detail_date_result;
        return $result;
    }
}
