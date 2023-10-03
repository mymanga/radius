<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\ViewComposers\SupportComposer;

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
        Schema::defaultStringLength(191);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        view()->composer('*', SupportComposer::class);

        // Validator::extend('formatted_phone', function ($attribute, $value, $parameters, $validator) {
        //     // Use the formatted_phone_number function to check if the phone number is valid
        //     return !empty(formatted_phone_number($value));
        // });
    }
}
