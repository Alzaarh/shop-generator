<?php

namespace App\Listeners;

use App\Events\SignupRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class SendVerificationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  SignupRequest  $event
     * @return void
     */
    public function handle(SignupRequest $event)
    {
        $code = bin2hex(random_bytes(64));

        $event->userData['verificationCode'] = $code;
        
        Redis::hset('tempUser:' . $event->userData['email'], 'verificationCode', Hash::make($code));

        Mail::to($event->userData['email'])->send(new VerificationMail($event->userData));
    }
}
