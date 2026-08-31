<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;

class NewContactNotification extends Mailable
{
    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function build(): self
    {
        return $this
            ->subject("New contact message #{$this->contactMessage->id}")
            ->view('emails.contact.admin-notification');
    }
}