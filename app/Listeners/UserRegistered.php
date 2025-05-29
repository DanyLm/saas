<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class UserRegistered
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // $user = $event->user;
        // Perform any functionality to the user here...
    }
}
