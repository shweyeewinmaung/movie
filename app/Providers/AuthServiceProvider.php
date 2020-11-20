<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
         Passport::routes();
        //    Passport::tokensExpireIn(now()->addHours(8));
        // Passport::refreshTokensExpireIn(now()->addDays(10));

        $gate->define('issuper',function($user){
            return $user->job_title=='super_admin';
        });
        $gate->define('isadmin',function($user){
            return $user->job_title=='admin';
        });
        $gate->define('isstaff',function($user){
            return $user->job_title=='staff';
        });
        
    }
}
