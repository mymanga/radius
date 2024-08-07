<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasprofile extends Model
{
    use HasFactory;

    protected $fillable = [
        'config',
        'api_port',
    ];

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }

    public function configured()
    {
        return $this->where('config', '=', 0);
    }
}
