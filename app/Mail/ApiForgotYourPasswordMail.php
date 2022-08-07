<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApiForgotYourPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $link)
    {
        $this->user = $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.api_forgot_your_password')
            ->subject(__('Reset Password Notification'))
            ->with([
                'name' => $this->user->name,
                'link' => $this->link,
            ]);
    }
}
