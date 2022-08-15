<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserHasSignedUpMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.new_user_has_signed_up')
            ->subject(__('New user has signed up'))
            ->with([
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ]);
    }
}
