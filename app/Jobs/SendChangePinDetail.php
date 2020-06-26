<?php

namespace App\Jobs;

use App\Mail\Frontend\User\SendChangePinDetailEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendChangePinDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * SendChangePinDetail constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $email = new SendChangePinDetailEmail($this->user);

            Mail::to($this->user['email'])->queue($email);
        } catch (\Exception $ex) {
            Log::error($ex);
        }
    }
}
