<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'nas_id',
        'network', 
        'subnet', 
        'title', 
        'comment', 
    ];

    public function nas()
    {
        return $this->belongsTo(Nas::class);
    }

}
