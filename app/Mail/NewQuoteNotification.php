<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewQuoteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead)
    {
    }

    public function build(): self
    {
        return $this
            ->subject("New quote request #{$this->lead->id}")
            ->view('emails.quotes.admin-notification');
    }
}