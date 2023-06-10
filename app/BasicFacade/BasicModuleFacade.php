<?php
 namespace App\BasicFacade;
 use Log;

use Illuminate\Support\Facades\Facade;

class BasicModuleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {        
        return 'BasicModule';
    }
}