<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use app\Models\User;

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
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->access == '1';
        });
        
        Gate::define('func', function (User $user) {
            $allowedValues = ['1', '2'];
            return in_array($user->access, $allowedValues);
        });

        Gate::define('user', function (User $user) {
            return $user->access == '3';
        });
    }
}