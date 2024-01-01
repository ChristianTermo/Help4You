<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $firstName = null;
    protected $lastName = null;
    protected $email = null;
    protected $reason = null;
    protected $description = null;
    protected $attachments = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName, $email, $reason, $description, $attachments)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->reason = $reason;
        $this->description = $description;
        $this->attachments = $attachments;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('support@mail.it')->view('support-email');
    }
}
