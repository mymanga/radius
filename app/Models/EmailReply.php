<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailConversation;

class EmailReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_conversation_id',
        'from',
        'to',
        'body',
    ];

    public function conversation()
    {
        return $this->belongsTo(EmailConversation::class, 'email_conversation_id');
    }
}
