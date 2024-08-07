<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PavelMironchik\LaravelBackupPanel\LaravelBackupPanelApplicationServiceProvider;

class LaravelBackupPanelServiceProvider extends LaravelBackupPanelApplicationServiceProvider
{
    /**
     * Register the Laravel Backup Panel gate.
     *
     * This gate determines who can access Laravel Backup Panel in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        // Gate::define('viewLaravelBackupPanel', function ($user) {
        //     return in_array($user->email, [
        //         // 'admin@your-site.com'
        //     ]);
        // });
        Gate::define('viewLaravelBackupPanel', function ($user) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Check if the user has the necessary permission using Spatie's Laravel Permission package
                if ($user->hasPermissionTo('manage system settings')) {
                    return true;
                } else {
                    // User is authenticated but doesn't have the necessary permission
                    return false;
                }
            } else {
                // User is not authenticated, redirect to the login page
                return redirect()->route('login');
            }
        });
    }
}
