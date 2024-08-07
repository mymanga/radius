<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadacctLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 
        'acct_input_octets', 
        'acct_output_octets',  
        'event_timestamp',
        'event_timestamp_raw', 
    ];

}
