<?php

namespace App\Listeners\Frontend\Auth;

use App\Jobs\SendUserConfirmation;
use App\Jobs\SendUserForgotPinOtp;
use App\Jobs\SendUserWelcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function onNeedsConfirmation($event)
    {
        $user = $event->user;
        $otp = $event->otp;
        dispatch(new SendUserConfirmation(
            $user,$otp
        ));
        \Log::info('User Confirmation job dispatched for: ' . $user['name']);
    }

    public function onNeedsWelcome($event)
    {
        $user = $event->user;
        dispatch(new SendUserWelcome(
            $user
        ));
        \Log::info('User Confirmation job dispatched for: ' . $user['name']);
    }

    public function onNeedsForgotMpinOpt($event)
    {
        $user = $event->user;
        $otp = $event->otp;
        dispatch(new SendUserForgotPinOtp(
            $user,$otp
        ));
        \Log::info('User Forgot pin job dispatched for: ' . $user['name']);
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Auth\UserConfirmation::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onNeedsConfirmation'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserWelcome::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onNeedsWelcome'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserForgotPin::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onNeedsForgotMpinOpt'
        );
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
