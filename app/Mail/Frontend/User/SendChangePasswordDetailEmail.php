<?php

namespace App\Mail\Frontend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendChangePasswordDetailEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->subject = trans('email.email_subject_label.change_password_detail');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('frontend.mail.change_password')
            ->with([
                'user' => $this->user
            ]);
    }
}
