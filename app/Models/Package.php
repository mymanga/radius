<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price",
        "download",
        "upload",
        "burst_download",
        "burst_upload",
        "burst_threshold_download",
        "burst_threshold_upload",
        "burst_time",
        "aggregation",
        "type",
        "info",
        "customer_upgrade",
    ];

    protected $casts = [
        "info" => "array",
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
