<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $psw;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param      $psw
     *
     * @internal param $psw
     */
    public function __construct(User $user, $psw)
    {
        $this->psw = $psw;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user_register')
            ->with([
                'psw' => $this->psw
            ]);

    }
}
