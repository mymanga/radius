<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class S3DiskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (!env('BACKUP_CODE')) {
            // Generate a backup code
            $simpleCode = generateBackupCode();
            
            // Trim whitespaces from APP_NAME and replace with hyphens
            $appName = str_replace(' ', '-', env('APP_NAME'));
            
            // Combine trimmed APP_NAME with $simpleCode
            $backupCode = $appName . '-' . $simpleCode; 
            
            // Write BACKUP_CODE to .env file
            file_put_contents(app()->environmentFilePath(), PHP_EOL . 'BACKUP_CODE='.$backupCode, FILE_APPEND);
        }                

        configureCloudStorage();
    }
}
