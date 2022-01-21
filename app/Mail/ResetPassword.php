<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $psw;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $psw
     */
    public function __construct(User $user, $psw)
    {
        $this->user = $user;
        $this->psw = $psw;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user_reset_password')->with([
                'psw' => $this->psw,
            ]);
    }
}
