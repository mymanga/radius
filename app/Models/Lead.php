<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;
use DB;

class Lead extends User
{
    use HasFactory, HasParent;

    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = bcrypt($value);
    }
}
