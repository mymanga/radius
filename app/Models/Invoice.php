<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'amount', 'status', 'due_date'];

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNote::class, 'invoice_id');
    }
    
    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'paid':
                return 'bg-success';
            case 'unpaid':
                return 'bg-warning';
            case 'canceled':
                return 'bg-danger';
            default:
                return 'bg-primary';
        }
    }

    public function getAdjustedAmountAttribute()
    {
        $creditNoteSum = $this->creditNotes->sum('amount');
        return $this->amount - $creditNoteSum;
    }

}
