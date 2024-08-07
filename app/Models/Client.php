<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

use DB;

class Client extends User
{
    use HasFactory, HasParent;

    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = bcrypt($value);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
   
    public function scopeIsActive($query)
    {
        return $query->whereHas("services", function ($service) {
            return $service->where("is_active", "=", 1);
        });
    }

    public function scopeInactive($query, $includeNoServices = false)
    {
        if ($includeNoServices) {
            return $query->whereDoesntHave('services')->orWhereHas('services', function ($serviceQuery) {
                $serviceQuery->where('is_active', 0);
            });
        } else {
            return $query->whereHas('services', function ($serviceQuery) {
                $serviceQuery->where('is_active', 0);
            });
        }
    }


    public function status()
    {
        if ($this->services->count() === 0) {
            return "<span class='badge badge-soft-info badge-border text-uppercase'>No Service</span>";
        }

        $isActive = $this->services->where('is_active', '=', 1)->count() > 0;

        $badgeType = $isActive ? 'success' : 'danger';
        $statusText = $isActive ? 'Active' : 'Blocked';

        return "<span class='badge badge-soft-$badgeType badge-border text-uppercase'>$statusText</span>";
    }

    public function apiStatus()
    {
        if ($this->services->count() === 0) {
            return 'No Service';
        }

        $isActive = $this->services->where('is_active', '=', 1)->count() > 0;

        $statusText = $isActive ? 'Active' : 'Blocked';

        return $statusText;
    }



    public function delete()
    {
        $this->messages()->delete();

        return parent::delete();
    }

    // Define the relationship with Service model
    public function activeServices()
    {
        // Subquery to fetch the latest radacctid for each framedipaddress
        $latestIdsSubquery = DB::table('radacct as r2')
            ->select('r2.framedipaddress', DB::raw('MAX(r2.radacctid) as max_id'))
            ->whereNull('r2.acctstoptime')
            ->groupBy('r2.framedipaddress');

        // Join the services table with the result of the subquery and the radacct table
        return $this->hasMany(Service::class)
            ->joinSub($latestIdsSubquery, 'latest_ids', function ($join) {
                $join->on('services.ipaddress', '=', 'latest_ids.framedipaddress');
            })
            ->join('radacct as r1', function ($join) {
                $join->on('services.ipaddress', '=', 'r1.framedipaddress')
                    ->where('r1.radacctid', '=', DB::raw('latest_ids.max_id'))
                    ->whereNull('r1.acctstoptime');
            })
            ->select('services.*', 'r1.*');  // Ensure you fetch all necessary columns
    }

}
