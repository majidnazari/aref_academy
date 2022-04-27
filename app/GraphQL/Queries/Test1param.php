<?php

namespace App\GraphQL\Queries;

final class Test1param
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        return "hi  " . $args["name"];
    }
}
