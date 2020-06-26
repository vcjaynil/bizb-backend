<?php

namespace App\Jobs;

use App\Mail\Frontend\User\UserConfirmEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    protected $user;
    protected $otp;

    /**
     * SendUserConfirmation constructor.
     * @param $user
     * @param $otp
     */
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $email = new UserConfirmEmail($this->user, $this->otp);

            Mail::to($this->user['email'])->queue($email);
        } catch (\Exception $ex) {
            Log::error($ex);
        }
    }
}
