<?php

namespace App\Listeners;

use App\Helpers\HandleLoginActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedOutListener
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
        if (auth()->check()) {
            $email = auth()->user()->email;
            $ip = request()->ip();
            $userAgent = request()->userAgent();

            HandleLoginActivity::storeActivity($email, $ip, $userAgent, 'Logged Out');
        }
    }
}
