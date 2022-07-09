<?php

namespace App\AuthFacade;
use App\Models\User;
use Illuminate\Support\Facades\Facade;

class CheckAuthFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'checkauth'; // same as bind method in service provider
    }
} 