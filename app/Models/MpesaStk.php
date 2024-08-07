<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaStk extends Model
{
    use HasFactory;

    protected $table = 'mpesa_stks';

    protected $fillable = [
        'CheckoutRequestID',
        'MerchantRequestID',
        "Account",
        'BusinessShortCode',
        'Amount',
        'ReceiptNumber',
        'PhoneNumber',
        'ResultDesc',
        'ResultCode',
        'Type',
        'PlanId',
    ];
}
