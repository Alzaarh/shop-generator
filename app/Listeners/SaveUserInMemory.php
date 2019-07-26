<?php

namespace App\Listeners;

use App\Events\SignupRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveUserInMemory implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  SignupRequest  $event
     * @return void
     */
    public function handle(SignupRequest $event)
    { 
        Redis::hmset('tempUser:' . $event->userData['email'], $event->userData);
        
        Redis::hincrby('tempUser:' . $event->userData['email'], 'verificationSentCount', 1);

        Redis::expire('tempUser:' . $event->userData['email'], 3600);
    }
}
