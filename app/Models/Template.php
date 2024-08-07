<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "type", "content"];

    public function scopeSms($query)
    {
        return $query->where("type", "=", "sms");
    }

    public function scopeEmail($query)
    {
        return $query->where("type", "=", "email");
    }
}
