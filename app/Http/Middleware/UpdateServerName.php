<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

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

        // Check if the 'radius' database connection is configured
        if (config("database.connections.mysql.database") === "radius") {
            // Check if the 'settings' table exists in the 'radius' database
            if (Schema::connection("mysql")->hasTable("settings")) {
                // Retrieve the server name from the cache
                $cachedServerName = Cache::get("server_name");

                // If the server name is not in the cache or has changed, update the database and the cache
                if ($cachedServerName !== $serverName) {
                    // Get or create a setting instance with the key 'server_name'
                    setting(["server_name" => $serverName])->save();

                    // Update the cache with a new expiration time of 24 hours
                    Cache::put("server_name", $serverName, now()->addHours(24));
                }

                // Retrieve LB-URL and LB-IP values from the cache
                $lb_url = Cache::get("lb_url");
                $lb_ip = Cache::get("lb_ip");

                if (!$lb_url || !$lb_ip) {
                    // Determine the protocol (http or https) based on server environment
                    $this_protocol =
                        (isset($_SERVER["HTTPS"]) &&
                            $_SERVER["HTTPS"] == "on" or
                        isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) and
                            $_SERVER["HTTP_X_FORWARDED_PROTO"] === "https")
                            ? "https://"
                            : "http://";

                    // Get the base domain (hostname) from the server environment
                    $this_base_domain =
                        getenv("SERVER_NAME") ?:
                        $_SERVER["SERVER_NAME"] ?:
                        getenv("HTTP_HOST") ?:
                        $_SERVER["HTTP_HOST"];

                    // Get your server's IP address
                    $this_ip =
                        getenv("SERVER_ADDR") ?:
                        $_SERVER["SERVER_ADDR"] ?:
                        gethostbyname(gethostname());

                    // Construct the LB-URL with only protocol and base domain
                    $lb_url = $this_protocol . $this_base_domain;

                    // Set LB-IP value
                    $lb_ip = $this_ip;

                    // Cache the LB-URL and LB-IP values for 24 hours
                    Cache::put("lb_url", $lb_url, now()->addHours(24));
                    Cache::put("lb_ip", $lb_ip, now()->addHours(24));

                    // Save the values in the Laravel settings table
                    setting(["lb_url" => $lb_url])->save();
                    setting(["lb_ip" => $lb_ip])->save();
                }
            }
        }

        // Handle the update check and cache the data for 24 hours
        $api = new \LicenseBoxExternalAPI();

        $updateData = Cache::remember("update_data", 60 * 24, function () use (
            $api
        ) {
            return $api->check_update();
        });

        // Share the update data with all your views
        view()->share("updateData", $updateData);

        return $next($request);
    }
}
