<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class UpdateServerName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $serverName = $request->getHttpHost();

        // Retrieve the server name from the cache
        $cachedServerName = Cache::get('server_name');

        // If the server name is not in the cache or has changed, update the database and the cache
        if ($cachedServerName !== $serverName) {
            
            // Get or create a setting instance with the key 'server_name'
            setting(['server_name' => $serverName])->save();
            
            // Update the cache with a new expiration time of 24 hours
            Cache::put('server_name', $serverName, now()->addHours(24));
        }

        // Handle the update check and cache the data for 24 hours
        $api = new \LicenseBoxExternalAPI();

        $updateData = Cache::remember('update_data', 60 * 24, function () use ($api) {
            return $api->check_update();
        });

        // Share the update data with all your views
        view()->share('updateData', $updateData);

        return $next($request);
    }
}
