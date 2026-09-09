<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;

class ContactConfirmation extends Mailable
{
    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('We received your message | Bonyaan')
            ->view('emails.contact.confirmation');
    }
}