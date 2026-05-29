<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShoppingListMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $user,
        public $items,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu lista de la compra – RecipEZ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.shopping-list',
        );
    }
}
