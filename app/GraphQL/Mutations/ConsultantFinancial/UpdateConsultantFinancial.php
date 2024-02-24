<?php

namespace App\GraphQL\Mutations\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use Carbon\Carbon;
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
        $user_id = auth()->guard('api')->user()->id;
        $branch_id = auth()->guard('api')->user()->branch_id;
        $user_type = auth()->guard('api')->user()->group->type;

        // $ConsultantFinancial=ConsultantFinancial::query();
        $ConsultantFinancial = ConsultantFinancial::where("consultant_id", $args['consultant_id']);
        $ConsultantFinancial->where("student_id", $args['student_id']);


        if ($branch_id) {
            $ConsultantFinancial->where("branch_id", $branch_id);
        }
        //else {
        //     $ConsultantFinancial->whereNull("branch_id");
        // }

        if (isset($args['year_id'])) {
            $ConsultantFinancial->where("year_id", $args['year_id']);
        } else {
            $ConsultantFinancial->whereNull("year_id");
        }
        $ConsultantFinancial = $ConsultantFinancial->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->first();

        if (!$ConsultantFinancial) {
            return Error::createLocatedError("CONSULTANTFINANCIAL-UPDATE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروزرسانی مالی مشاور: رکورد مورد نظر یافت نشد.");
        }

        $data = [
            "consultant_id" =>  $ConsultantFinancial->consultant_id,
            "student_id" => $ConsultantFinancial->student_id,
            "branch_id" => $ConsultantFinancial->branch_id,
            "year_id" => $ConsultantFinancial->year_id,
            //"description" => $ConsultantFinancial->year_id,
            // "consultant_definition_detail_id"=>$args['consultant_definition_detail_id'],
        ];

        if ($user_type === "consultant_acceptor" && (isset($args['student_status']))) { //*&& ($user_type === "consultant_manager")*/ ) { // when user comsultant manager change the manager status field it's id saves

            $data["user_id_student_status"] = $user_id;
            $data["student_status"] = $args['student_status'];

            if (in_array($args['student_status'], ["refuse_pending", "fire_pending"])) {
                $data["manager_status"] = "pending";
            }
        }

        if ($user_type === "consultant_manager" && (isset($args['manager_status']))) {
            //*&& ($user_type === "consultant_manager")*/ ) { // when user comsultant manager change the manager status field it's id saves
            $data["user_id_manager"] = $user_id;
            // $data["user_id_student_status"] = $user_id;

            $data["manager_status"] = isset($args['manager_status']) ? $args['manager_status'] : "pending";
            $data["student_status"] = isset($args['student_status']) ? $args['student_status'] :  "ok";

            if (in_array($args['student_status'], ["refused", "fired"])) {
                $data["financial_status"] = "pending";
                $data["manager_status"] = "pending";
            }
        }


        if ($user_type === "financial" && (isset($args['financial_status'])) /*&& ($user_type === "financial")*/) { // when user comsultant manager change the manager status field it's id saves
            $data["user_id_financial"] = $user_id;
            //$data["user_id_student_status"] = $user_id;

            $data["financial_status_updated_at"] = Carbon::now();
            $data["financial_refused_status"] = isset($args['financial_refused_status']) ? $args['financial_refused_status'] : "noMoney";
            $data["financial_status"] = isset($args['financial_status']) ? $args['financial_status'] : "pending";
            //$data["student_status"] = isset($args['student_status']) ? $args['student_status'] :  "ok";
        }
        if ($user_type === "admin") {

            Log::info("inside update controller and args are:" . json_encode($args));
            // when user admin change the manager status field it's id saves            
            //$data["user_id_student_status"] = $user_id;

            if (isset($args['student_status'])) {
                $data["user_id_student_status"] = $user_id;
                $data["student_status"] = $args['student_status'];
            }

            if (isset($args['manager_status'])) {
                $data["user_id_manager"] = $user_id;
                $data["manager_status"] = $args['manager_status'];
            }

            if(isset($args['financial_status'])){
                $data["user_id_financial"] = $user_id;
                $data["financial_status"] = $args['financial_status'] ;
            }
            if(isset($args['financial_refused_status'])){
                $data["financial_status_updated_at"] = Carbon::now();
                $data["financial_refused_status"] = isset($args['financial_refused_status']) ? $args['financial_refused_status'] : "noMoney";
            }

            //$data["student_status"] = isset($args['student_status']) ? $args['student_status'] :  "ok";
        }
        // if (isset($args['student_status'])  /* && (in_array($user_type ,["manager" , "admin" ]) ) */ ) { // when user comsultant manager change the manager status field it's id saves
        //     $data["user_id_student_status"] = $user_id;
        //     $data["student_status"] = isset($args['student_status']) ? $args['student_status'] :  "OK";
        // }
        if (isset($args['description'])) {
            $data["description"] = $args['description'];
        }

       // Log::info("inside update controller and data to update  are:" . json_encode($data));

        $ConsultantFinancial->fill($data);
        $ConsultantFinancial->save();
        return $ConsultantFinancial;
    }
}
