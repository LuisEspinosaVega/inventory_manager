<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Definir los permisos para la aplicacion 😓
        Gate::define('main_admin', function (User $user) {
            if (!$user->profile->rol->main_admin) {
                return false;
            }
            return true;
        });

        Gate::define('main_inventory', function (User $user) {
            if (!$user->profile->rol->main_inventory) {
                return false;
            }
            return true;
        });

        Gate::define('edit_inventory', function (User $user) {
            if (!$user->profile->rol->edit_inventory) {
                return false;
            }
            return true;
        });

        Gate::define('main_finance', function (User $user) {
            if (!$user->profile->rol->main_finance) {
                return false;
            }
            return true;
        });

        Gate::define('edit_finance', function (User $user) {
            if (!$user->profile->rol->edit_finance) {
                return false;
            }
            return true;
        });

        Gate::define('main_rh', function (User $user) {
            if (!$user->profile->rol->main_rh) {
                return false;
            }
            return true;
        });

        Gate::define('edit_rh', function (User $user) {
            if (!$user->profile->rol->edit_rh) {
                return false;
            }
            return true;
        });

        Gate::define('main_social', function (User $user) {
            if (!$user->profile->rol->main_social) {
                return false;
            }
            return true;
        });

        Gate::define('edit_social', function (User $user) {
            if (!$user->profile->rol->edit_social) {
                return false;
            }
            return true;
        });
    }
}
