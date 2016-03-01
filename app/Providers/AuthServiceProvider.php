<?php

namespace App\Providers;

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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->before(function ($user, $permission, $model = null, $additional = null) {

            if ( ! is_null($additional)) {
                return;
            }

            // admins can do everything!
            if($user->hasRole('administrator')){
                return true;
            }

            $result = $user->hasPermission($permission);

            // dont return a false response as we want to fall through to policies then.
            if($result === true){
                return true;
            }
        });
    }
}
