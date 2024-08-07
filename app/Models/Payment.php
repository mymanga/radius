<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'transaction_id',
        'transaction_time',
        'amount',
        'business_short_code',
        'bill_reference',
        'invoice_number',
        'org_account_balance',
        'third_party_trans_id',
        'phone_number',
        'first_name',
        'middle_name',
        'last_name',
        'status',
    ];
}
