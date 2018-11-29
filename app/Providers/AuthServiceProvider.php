<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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


    public function boot(GateContract $gate,User $user)
    {



        $this->registerPolicies($gate);


        foreach ($this->getPermission() as $permission)
        {
            $gate->define($permission->name,function ($user) use ($permission)
            {
                return $user->hasRole($permission->roles);
            });
        }

        $this->registerPolicies();


    }



    protected function getPermission()
    {
        return Permission::with('roles')->get();

    }



}
