<?php

namespace App\GraphQL\Entities;
use Log;

class Student {
    public function __invoke($rep)
    {         
        return ["__typename" => "Student", "id" => 69];
    }
}