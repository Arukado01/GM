<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $admins = User::where('role_id', 1)->get()->count();
        $supervisors = User::where('role_id', 2)->get()->count();
        $clients = User::where('role_id', 3)->get()->count();

        $role_admin = Role::find(1)->hashid;
        $role_supervisors = Role::find(2)->hashid;
        $role_clients = Role::find(3)->hashid;

        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

        View::share(compact(
            'admins',
            'supervisors',
            'clients',
            'role_admin',
            'role_supervisors',
            'role_clients'
        ));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
