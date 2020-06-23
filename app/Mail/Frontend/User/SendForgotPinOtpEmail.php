<?php

namespace App\Mail\Frontend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgotPinOtpEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $otp;

    /**
     * SendForgotPinOtpEmail constructor.
     * @param $user
     * @param $otp
     */
    public function __construct($user,$otp)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->subject = trans('email.email_subject_label.forget_pin_otp');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('frontend.mail.forgot_pin_otp')
            ->with([
                'user'  => $this->user,
                'otp'   => $this->otp
            ]);
    }
}
