<?php

namespace App\Listeners;

use App\Helpers\HandleLoginActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginFailedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $email = $event->user ? $event->user->email : $event->credentials['email'];
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        HandleLoginActivity::storeActivity($email, $ip, $userAgent, 'Failed Login Attempt');
    }
}
