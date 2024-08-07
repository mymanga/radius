<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailReply;
use Illuminate\Support\Str;


class EmailConversation extends Model
{
    use HasFactory;

    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_SOLVED = 'solved';

    protected $fillable = [
        'user_id',
        'from',
        'to',
        'subject',
        'body',
        'priority',
        'status',
        'thread_id',
        'is_read',
        'mail_id',
        'ticket_number',
    ];

    /**
     * Get the user that owns the email conversation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(EmailReply::class);
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return '<span class="badge badge-soft-info badge-border">New</span>';
            case self::STATUS_PENDING:
                return '<span class="badge badge-soft-warning badge-border">Pending</span>';
            case self::STATUS_SOLVED:
                return '<span class="badge badge-soft-success badge-border">Solved</span>';
            default:
                return '<span class="badge badge-soft-light badge-border">Unknown</span>';
        }
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    protected static function booted()
    {
        static::creating(function ($conversation) {
            $conversation->ticket_number = 'TICKET-' . now()->format('YmdHis') . '-' . Str::random(5);
        });
    }

}
