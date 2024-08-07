<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotspotSession extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotspot_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac',
        'ip',
        'username',
        'link_login',
        'link_orig',
        'error',
        'chap_id',
        'chap_challenge',
        'link_login_only',
        'link_orig_esc',
        'mac_esc',
        'payment_id',
        'requestid',
        'status',
        'voucher_code'
    ];
}
