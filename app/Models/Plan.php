<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'data_limit',
        'price',
        'simultaneous_use_limit',
        'speed_limit',
        'public',
        'valid_from',
        'valid_to',
        'valid_days',
        'device_type',
        'offer',
        'offer_details',
        'discount_rate',
    ];

}
