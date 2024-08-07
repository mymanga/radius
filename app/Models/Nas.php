<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Nas extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $table = 'nas';
    public $timestamps = false;

    protected $fillable = [
        'nasname', 
        'shortname', 
        'secret',  
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function nasprofile()
    {
        return $this->hasOne(Nasprofile::class, 'nas_id','id');
    }

    public function networks()
    {
        return $this->hasMany(Network::class);
    }


    public static function getNasIdByNasName($nasname) {
        $nas = self::where('nasname', $nasname)->first();
        return $nas ? $nas->id : null;
    }

    public function getApiPortAttribute()
    {
        // Fetch the nasprofile related to the current Nas instance
        $nasprofile = $this->nasprofile;

        // Check if the nasprofile exists and the api_port is set
        // If not, return the default port 8728
        if ($nasprofile && $nasprofile->api_port) {
            return $nasprofile->api_port;
        }

        return 8728;
    }

}
