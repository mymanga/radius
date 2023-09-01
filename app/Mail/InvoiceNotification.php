<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $url;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param  Invoice  $invoice
     * @param  string   $url
     * @param  string   $status
     * @return void
     */
    public function __construct(Invoice $invoice, $url, $status)
    {
        $this->invoice = $invoice;
        $this->url = $url;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoice.notification')
            ->with([
                'invoiceNumber' => $this->invoice->invoice_number,
                'amount' => $this->invoice->amount,
                'url' => $this->url,
                'firstname' => $this->invoice->user->firstname,
                'status' => $this->status,
            ]);
    }
}

