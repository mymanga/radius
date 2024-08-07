<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Bavix\Wallet\Traits\HasWallet;
// use Bavix\Wallet\Interfaces\Customer;
// use Bavix\Wallet\Interfaces\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Service extends Model
{
    use HasFactory, HasTags;
    

    protected $fillable = [
        "username",
        "cleartextpassword",
        "package_id",
        "ipaddress",
        "is_active",
        "expiry",
        "price",
        "renewal",
        "grace_expiry",
        "mac_address",
        "description",
        "type",
        "info",
    ];

    protected $dates = ["expiry"];

    protected $casts = [
        'info' => 'array', 
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, "user_id");
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
    
    public function active()
    {
        return $this->where("is_active", 1);
    }

    public function status()
    {
        $servicesJsonPath = public_path('service_status.json');

        if (file_exists($servicesJsonPath)) {
            $servicesJson = json_decode(file_get_contents($servicesJsonPath), true);
        } else {
            $servicesJson = [];
        }

        $cleanedUsername = trim($this->username);

        // Use array_filter to filter the array based on username
        $filteredServices = array_filter($servicesJson, function ($item) use ($cleanedUsername) {
            return $item['service_username'] === $cleanedUsername;
        });

        // Take the first matching element
        $serviceInfo = reset($filteredServices);

        if ($this->isDormant(setting('dormancy'))) {
            return '<div class="badge badge-soft-primary badge-border fs-12">Dormant</div>';
        } elseif ($this->is_active == 0) {
            return '<div class="badge badge-soft-danger badge-border fs-12">Blocked</div>';
        } elseif ($serviceInfo && $serviceInfo['status'] === 'online') {
            return '<div class="badge badge-soft-success badge-border fs-12">Online</div>';
        } elseif ($serviceInfo && $serviceInfo['status'] === 'offline' && $serviceInfo['last_activity'] !== null) {
            $lastActivityTimestamp = strtotime($serviceInfo['last_activity']);
            $lastActivityFormatted = Carbon::createFromTimestamp($lastActivityTimestamp)->format('d M g:i A');
        
            return '<div class="badge badge-soft-warning badge-border fs-12">Last Online: ' . $lastActivityFormatted . '</div>';
        } else {
            return '<div class="badge badge-soft-info badge-border fs-12">Active</div>';
        }
    }



    public function getOnlineStatus()
    {
        $servicesJsonPath = public_path('service_status.json');

        if (file_exists($servicesJsonPath)) {
            $servicesJson = json_decode(file_get_contents($servicesJsonPath), true);
        } else {
            $servicesJson = [];
        }

        $cleanedUsername = trim($this->username);

        // Use array_filter to filter the array based on username
        $filteredServices = array_filter($servicesJson, function ($item) use ($cleanedUsername) {
            return $item['service_username'] === $cleanedUsername;
        });

        // Take the first matching element
        $serviceInfo = reset($filteredServices);

        if ($serviceInfo && $serviceInfo['status'] === 'online') {
            // Green dot for online
            return '<div class="dot green"></div>';
        } elseif ($serviceInfo && $serviceInfo['status'] === 'offline' && $serviceInfo['last_activity'] === Carbon::today()->toDateString()) {
            // Orange dot for online today
            return '<div class="dot orange"></div>';
        } else {
            // Grey dot for inactive
            return '';
        }
    }

    // Eloquent query scope to get services whose 'expiry' date is today.
    public function scopeExpiringToday($query)
    {
        return $query->whereDate('expiry', '=', Carbon::tomorrow()->startOfDay())
                    ->where(function ($query) {
                        $query->whereNull('grace_expiry')
                            ->orWhereDate('grace_expiry', '<=', Carbon::tomorrow()->startOfDay());
                    });
    }

    // Eloquent query scope to get dormant services (expired services) based on the number of days provided.
    public function scopeDormant($query, $numberOfDays)
    {
        $dateThreshold = Carbon::today()->subDays($numberOfDays);
        return $query->whereDate('expiry', '<', $dateThreshold);
    }

    public function isDormant($numberOfDays)
    {
        $dateThreshold = Carbon::today()->subDays($numberOfDays);
        
        return $this->expiry < $dateThreshold;
    }

    // Eloquent query scope to get services created within the current month.
    public function scopeCreatedThisMonth($query)
    {
        $now = Carbon::now();
        return $query->whereMonth('services.created_at', $now->month)
                    ->whereYear('services.created_at', $now->year);
    }

}
