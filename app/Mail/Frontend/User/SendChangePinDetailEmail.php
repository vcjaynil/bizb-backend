<?php

namespace App\Mail\Frontend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendChangePinDetailEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * SendChangePinDetailEmail constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->subject = trans('email.email_subject_label.change_pin_detail');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject($this->subject)
            ->view('frontend.mail.change_pin')
            ->with([
                'user' => $this->user
            ]);
    }
}
