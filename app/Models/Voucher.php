<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'info' => 'array', 
    ];

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'used':
                return '<div class="badge badge-soft-warning badge-border fs-12">Used</div>';
                break;
            case 'expired':
                return '<div class="badge badge-soft-danger badge-border fs-12">Expired</div>';
                break;
            default:
                return '<div class="badge badge-soft-info badge-border fs-12">Active</div>';
        }
    }

    public function getVoucherTypeAttribute()
    {
        if (($this->expiration_time !== null || $this->time !== null) && $this->data_limit === null) {
            // This is a time-based voucher
            return '<div class="badge badge-soft-primary badge-border fs-12">Time-Based</div>';
        } elseif (($this->expiration_time === null && $this->time === null) && $this->data_limit !== null) {
            // This is a data-based voucher
            return '<div class="badge badge-soft-primary badge-border fs-12">Data-Based</div>';
        } elseif (($this->expiration_time !== null || $this->time !== null) && $this->data_limit !== null) {
            // This is a time-and-data-based voucher
            return '<div class="badge badge-soft-primary badge-border fs-12">Time & Data</div>';
        } else {
            // Active voucher with no specific type
            return '<div class="badge badge-soft-info badge-border fs-12">Normal</div>';
        }
    }





    public function calculateDataUsage() {
        // Get the total number of octets received and sent for this voucher
        $totalData = DB::table('radacct')
                        ->where('username', $this->code)
                        ->sum(DB::raw('acctinputoctets + acctoutputoctets'));
    
        // Since 1 octet equals 1 byte, no conversion is necessary
        return $totalData;
    }

    public function isExpired() {
        // Check if the status is 'expired'
        if ($this->status === "expired") {
            return true;
        }
    
        // If voucher is based on both data and time
        if (isset($this->data_limit) && isset($this->expiration_time)) {
            // This is a time-and-data-based voucher
            if ($this->expiration_time < now() || $this->calculateDataUsage() >= $this->data_limit) {
                return true;
            }
        }
        // If voucher is based on time only
        else if (isset($this->expiration_time) && $this->data_limit === null) {
            // This is a time-based voucher
            if ($this->expiration_time < now()) {
                return true;
            }
        }
        // If voucher is based on data only
        else if ($this->expiration_time === null && isset($this->data_limit)) {
            // This is a data-based voucher
            if ($this->calculateDataUsage() >= $this->data_limit) {
                return true;
            }
        }
    
        // Voucher is not expired
        return false;
    }

    public function isDataCapExceeded() {
        // Get the total number of octets received and sent for this voucher
        $totalData = DB::table('radacct')
                        ->where('username', $this->code)
                        ->sum(DB::raw('acctinputoctets + acctoutputoctets'));
    
        // Get the data cap for this voucher
        $dataCap = DB::table('vouchers')
                        ->where('code', $this->code)
                        ->value('data_limit');
        
        // Since 1 octet equals 1 byte, no conversion is necessary
        return $totalData >= $dataCap;
    }
    

}
