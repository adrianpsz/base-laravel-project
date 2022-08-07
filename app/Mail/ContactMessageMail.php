<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.contact_message')
            ->subject($this->message->subject)
            ->replyTo($this->message->email)
            ->with([
                'name' => $this->message->name,
                'email' => $this->message->email,
                'subject' => $this->message->subject,
                'body' => $this->message->message,
                'ip' => $this->message->ip
            ]);
    }
}
