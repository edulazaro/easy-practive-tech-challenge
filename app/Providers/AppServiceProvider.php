<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('manage-client', function (User $user, Client $client) {
            $check = $user->id === $client->user_id;

            return $check ? Response::allow() : Response::deny();
        });
    }
}
