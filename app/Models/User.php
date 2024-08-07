<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Parental\HasChildren;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Spatie\Permission\Traits\HasRoles;
use \Spatie\Tags\HasTags;

class User extends Authenticatable implements Wallet
{
    use HasFactory, Notifiable, HasChildren, HasWallet, HasRoles, HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'lastname', 
        'username', 
        'email', 
        'password', 
        'location',
        'latitude',
        'longitude',
        'phone', 
        'birthday',
        'category',
        'billingType', 
        'identification',
        'info',
        'text_pass',
        'avatar',
    ];
   
    protected $childTypes = [
        'client' => Client::class,
        'lead' => Lead::class,
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'info' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function fullName()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
}
