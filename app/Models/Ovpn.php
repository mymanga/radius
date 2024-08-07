<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ovpn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'ip', 
    ];
}
