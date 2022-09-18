<?php
 namespace App\BasicFacade;
 use Log;

use Illuminate\Support\Facades\Facade;

class BasicModuleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        //Log::info("the facade accessor is run.");
        //return "App\BasicFacade\CreateModel";
        return 'BasicModule';
    }
}