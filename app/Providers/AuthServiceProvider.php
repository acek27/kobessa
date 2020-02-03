<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('super', function ($user) {
            return $user->role_id == 1;
        });
        Gate::define('peternakan', function ($user) {
            return $user->role_id == 2;
        });
        Gate::define('pertanian', function ($user) {
            return $user->role_id == 3;
        });
        Gate::define('koperasi', function ($user) {
            return $user->role_id == 4;
        });
        Gate::define('ppl', function ($user) {
            return $user->role_id == 5;
        });
        Gate::define('petani', function ($user) {
            return $user->role_id == 6;
        });
        Gate::define('juruair', function ($user) {
            return $user->role_id == 7;
        });    
        Gate::define('suplier', function ($user) {
            return $user->role_id == 8;
        });
    }
}
