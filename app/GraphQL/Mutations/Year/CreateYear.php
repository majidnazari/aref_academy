<?php

namespace App\GraphQL\Mutations\Year;

use App\Models\Year;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateYear
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
        $year_date=[
            'user_id_creator' => $user_id,
            'name' => $args['name'],
            'active' => $args['active']
            
        ];
        $exist_year=Year::where('name',$args['name'])->where('active',$args['active'])->first();
        if($exist_year){
            return Error::createLocatedError("YEAR-CREATE-RECORD_IS_EXIST");
        }
        $year_resut=Year::create($year_date);
        return $year_resut;
    }

}
