<?php

namespace App\Listerners;

use App\Events\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserLoginNotification implements ShouldQueue
{
    public $queue = 'user_login';

    public $delay = 60;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    /**
     * Handle the event.
     *
     * @param  User  $event
     * @return void
     */
    public function handle(User $event)
    {
        $event->onLoginIn();
    }
}
