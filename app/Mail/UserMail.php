<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class UserMail extends Mailable
{
  use Queueable, SerializesModels;

  public $details, $user;
  
  public function __construct($details, $user)
  {
    $this->details = $details;
    $this->user    = $user;
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Envío de correos masivos',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'emails.userMail',
      with: [
        'user'  => $this->user,
      ]
    );
  }
}