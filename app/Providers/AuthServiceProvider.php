<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();

        $this->registerPolicies();
        
        Passport::routes();

        //Passport::tokensExpireIn(now()->addDays(15)); 
        Passport::tokensExpireIn(now()->addMinutes(20)); 
        Passport::refreshTokensExpireIn(now()->addHours(1));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        //Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        
        // $user=User::where('deleted_at', null)      
        // ->with('groups')->pivot->group_id;
        
        // Gate::define('GetAllUsers',function(User $user){
        //     $user_find=$user->where('deleted_at', null)
        //     ->whereHas('groups',function($query){
        //         $query->where("groups.name","admin");

        //     })
        //     ->with('groups')
        //     ->get();
        //     if($user_find)
        //     {
        //         return true;
        //     }
        //    return true;

        // });
    }
}
